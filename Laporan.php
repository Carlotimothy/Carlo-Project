<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Laporan extends CI_Controller {

	function __construct(){
		parent::__construct();
	    $this->load->library("session");
	    if ($this->session->userdata('logged_in') === FALSE || $this->session->userdata('logged_in') === NULL) {
        	redirect(base_url().'login');
		}
		$this->load->model('Produk_model');
		$this->load->model('Laporan_model');
	}



	public function transaksiDetail() {
		//$data_product = $this->Produk_model->getAllProduk();

		$data_laporan = "";
		$data_form = array(	'form_data_awal' => "",
							'form_data_akhir' => ""
							);
		if ($this->input->post('search_tanggal_awal') AND $this->input->post('search_tanggal_akhir')) {
			$data_laporan = "1";
			$date_awal = $this->input->post('search_tanggal_awal');
			$data_awal_ori = $date_awal;
			$date_awal = str_replace('/', '-', $date_awal);
			$date_awal = date('Y-m-d', strtotime($date_awal));
			$date_akhir = $this->input->post('search_tanggal_akhir');
			$data_akhir_ori = $date_akhir;
			$date_akhir = str_replace('/', '-', $date_akhir);
			$date_akhir = date('Y-m-d', strtotime($date_akhir));

			$data_laporan = $this->Laporan_model->getLaporanTransaksiDetail($date_awal, $date_akhir);

			$data_form = array(	'form_data_awal' => $data_awal_ori,
								'form_data_akhir' => $data_akhir_ori
								);
		}


		// EXPORT TO EXCEL
		if ($this->input->post('button_submit') == "export") {
			$filename =  "Laporan-Transaksi-Detail[".$data_awal_ori.']['.$data_akhir_ori."].csv";   
			$fp = fopen('php://output', 'w');            
			header('Content-Type: text/csv; charset=utf-8');       
			header('Content-type: application/csv');
			header('Content-Disposition: attachment; filename='.$filename );

			echo "Laporan Transaksi Detail\n";
			echo "Tanggal Awal : ".$data_awal_ori." \n";
			echo "Tanggal Akhir : ".$data_akhir_ori." \n";
			echo "\n";

			$exceldata = array(
	                    "Kode Transaksi",   // dummy column name here 
	                    "Tanggal Transaksi",
	                    "Deskripsi Transaksi",
	                    "Kode Barang",
	                    "Nama Barang",
	                    "Harga",
	                    "Deskripsi Barang",
	                    "Nama Pembeli",
	                    "Telepon Pembeli"
	                    );
            fputcsv($fp, $exceldata );

			foreach ($data_laporan as $data) {
	            $exceldata = array(
	                    $data['trid'],   // dummy column name here 
	                    $data['dateOrder'],
	                    $data['transactionDescriptive'],
	                    $data['pid'],
	                    $data['productName'],
	                    $data['tr_price'],
	                    $data['productDescriptive'],
	                    $data['buyerName'],
	                    $data['buyerPhone']
	                    );
	            fputcsv($fp, $exceldata );
	        }
			die();
		}


		$data = array (	'namaUser' => $this->session->userdata('namaUser'),
						'data_laporan' => $data_laporan,
						'form_state' => $data_form
		 				);
		$this->load->view('laporan_detail_view',$data);
	}




	public function transaksiPertanggal() {
		//$data_product = $this->Produk_model->getAllProduk();

		$data_laporan = "";
		$data_form = array(	'form_data_awal' => "",
							'form_data_akhir' => ""
							);
		if ($this->input->post('search_tanggal_awal') AND $this->input->post('search_tanggal_akhir')) {
			$data_laporan = "1";
			$date_awal = $this->input->post('search_tanggal_awal');
			$data_awal_ori = $date_awal;
			$date_awal = str_replace('/', '-', $date_awal);
			$date_awal = date('Y-m-d', strtotime($date_awal));
			$date_akhir = $this->input->post('search_tanggal_akhir');
			$data_akhir_ori = $date_akhir;
			$date_akhir = str_replace('/', '-', $date_akhir);
			$date_akhir = date('Y-m-d', strtotime($date_akhir));

			$data_laporan = $this->Laporan_model->getLaporanTransaksiPertanggal($date_awal, $date_akhir);
			$data_form = array(	'form_data_awal' => $data_awal_ori,
								'form_data_akhir' => $data_akhir_ori
								);
		}

		// EXPORT TO EXCEL
		if ($this->input->post('button_submit') == "export") {
			$filename =  "Laporan-Pertanggal[".$data_awal_ori.']['.$data_akhir_ori."].csv";   
			$fp = fopen('php://output', 'w');            
			header('Content-Type: text/csv; charset=utf-8');       
			header('Content-type: application/csv');
			header('Content-Disposition: attachment; filename='.$filename );

			echo "Laporan Pertanggal\n";
			echo "Tanggal Awal : ".$data_awal_ori." \n";
			echo "Tanggal Akhir : ".$data_akhir_ori." \n";
			echo "\n";

			$exceldata = array(
	                    "Tanggal Transaksi",   // dummy column name here 
	                    "Jumlah Transaksi",
	                    "Total Harga"
	                    );
            fputcsv($fp, $exceldata );
            $total_jumlahtransaksi = 0;
			$total_totalharga = 0;
			foreach ($data_laporan as $data) {
	            $exceldata = array(
	                    $data['dateOrder'],   // dummy column name here 
	                    $data['jumlahTransaksi'],
	                    $data['totalHarga']
	                    );
	            $total_jumlahtransaksi += $data['jumlahTransaksi'];
				$total_totalharga += $data['totalHarga'];
	            fputcsv($fp, $exceldata );
	        }
	        $exceldata = array(
	                    "Total", 
	                    $total_jumlahtransaksi,
	                    $total_totalharga
	                    );
	        fputcsv($fp, $exceldata );
	        
			die();
		}

		// /var_dump($data_laporan);
		$data = array (	'namaUser' => $this->session->userdata('namaUser'),
						'data_laporan' => $data_laporan,
						'form_state' => $data_form
		 				);
		$this->load->view('laporan_pertanggal_view',$data);
	}





	public function transaksiProfit() {

		$data_laporan = "";
		$data_form = array(	'form_data_awal' => "",
							'form_data_akhir' => ""
							);
		if ($this->input->post('search_tanggal_awal') AND $this->input->post('search_tanggal_akhir')) {
			$date_awal = $this->input->post('search_tanggal_awal');
			$data_awal_ori = $date_awal;
			$date_awal = str_replace('/', '-', $date_awal);
			$date_awal = date('Y-m-d', strtotime($date_awal));
			$date_akhir = $this->input->post('search_tanggal_akhir');
			$data_akhir_ori = $date_akhir;
			$date_akhir = str_replace('/', '-', $date_akhir);
			$date_akhir = date('Y-m-d', strtotime($date_akhir));

			$data_laporan = $this->Laporan_model->getLaporanTransaksiProfit($date_awal, $date_akhir);
			$data_form = array(	'form_data_awal' => $data_awal_ori,
								'form_data_akhir' => $data_akhir_ori
								);
		}

		// EXPORT TO EXCEL
		if ($this->input->post('button_submit') == "export") {
			$filename =  "Laporan-Profit[".$data_awal_ori.']['.$data_akhir_ori."].csv";   
			$fp = fopen('php://output', 'w');            
			header('Content-Type: text/csv; charset=utf-8');       
			header('Content-type: application/csv');
			header('Content-Disposition: attachment; filename='.$filename );

			echo "Laporan Profit\n";
			echo "Tanggal Awal : ".$data_awal_ori." \n";
			echo "Tanggal Akhir : ".$data_akhir_ori." \n";
			echo "\n";

			$exceldata = array(
	                    "Tanggal",   // dummy column name here 
	                    "Harga Modal",
	                    "Harga Transaksi"
	                    );
            fputcsv($fp, $exceldata );

            $profit = "";
            $total_totalModal = "";
            $total_price_order = "";
			foreach ($data_laporan as $data) {
	            $exceldata = array(
	                    $data['tanggal'],   // dummy column name here 
	                    $data['totalModal'],
	                    $data['price_order']
	                    );

	            $total_totalModal += $data['totalModal'];
                $total_price_order += $data['price_order']; 
                $profit_now = $data['price_order'] - $data['totalModal'];
                $profit += $profit_now;

	            fputcsv($fp, $exceldata );
	        }


	        $exceldata = array(
	                    "Total", 
	                    $total_totalModal,
	                    $total_price_order
	                    );
	        fputcsv($fp, $exceldata );

	        $exceldata = array(
	                    "Profit",
	                    $profit,
	                    ""
	                    );
	       	fputcsv($fp, $exceldata );




			die();
		}


		//var_dump($data_laporan);
		$data = array (	'namaUser' => $this->session->userdata('namaUser'),
						'data_laporan' => $data_laporan,
						'form_state' => $data_form
		 				);
		$this->load->view('laporan_profit_view',$data);

	}





}
