<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Sales extends MY_Controller
{
    function __construct()
    {
        parent::__construct();

        if (!$this->loggedIn) {
            $this->session->set_userdata('requested_page', $this->uri->uri_string());
            redirect('login');
        }
        if ($this->Supplier) {
            $this->session->set_flashdata('warning', lang('access_denied'));
            redirect($_SERVER["HTTP_REFERER"]);
        }
        $this->lang->load('sales', $this->Settings->language);
        $this->load->library('form_validation');
        $this->load->model('sales_model');
		$this->load->model('Site');
        $this->load->model('sale_order_model');
        $this->load->model('products_model');
		$this->load->model('pos_model');
        $this->digital_upload_path = 'files/';
        $this->upload_path = 'assets/uploads/';
        $this->thumbs_path = 'assets/uploads/thumbs/';
        $this->image_types = 'gif|jpg|jpeg|png|tif';
        $this->digital_file_types = 'zip|psd|ai|rar|pdf|doc|docx|xls|xlsx|ppt|pptx|gif|jpg|jpeg|png|tif|txt';
        $this->allowed_file_size = '10240';
        $this->data['logo'] = true;
		
		$this->load->helper('text');
        $this->pos_settings = $this->pos_model->getSetting();
        $this->pos_settings->pin_code = $this->pos_settings->pin_code ? md5($this->pos_settings->pin_code) : NULL;
        $this->data['pos_settings'] = $this->pos_settings;
        
        if(!$this->Owner && !$this->Admin) {
            $gp = $this->site->checkPermissions();
            $this->permission = $gp[0];
            $this->permission[] = $gp[0];
        } else {
            $this->permission[] = NULL;
        }
        $this->default_biller_id = $this->site->default_biller_id();
    }

    function index($warehouse_id = NULL)
    {
		
		$this->erp->checkPermissions('index',null, 'sales');
		$this->load->model('reports_model');
		 
		if(isset($_GET['d']) != ""){
			$date = $_GET['d'];
			$this->data['date'] = $date;
		}
		 
		$this->data['users'] = $this->reports_model->getStaff();
		$this->data['products'] = $this->site->getProducts();
        $this->data['warehouses'] = $this->site->getAllWarehouses();
        $this->data['billers'] = $this->site->getAllCompanies('biller');
		
        $this->data['error'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('error');
        if ($this->Owner || $this->Admin || !$this->session->userdata('warehouse_id')) {
            $this->data['warehouses'] = $this->site->getAllWarehouses();
            $this->data['warehouse_id'] = $warehouse_id;
            $this->data['warehouse'] = $warehouse_id ? $this->site->getWarehouseByID($warehouse_id) : NULL;
			
        } else {
			
            $this->data['warehouses'] = $this->products_model->getUserWarehouses();
			if($warehouse_id){
				$this->data['warehouse_id'] = $warehouse_id;
				$this->data['warehouse'] = $warehouse_id ? $this->site->getWarehouseByID($warehouse_id) : NULL;
			}else{
				//$this->erp->print_arrays(str_replace(',', '-',$this->session->userdata('warehouse_id')));
				$this->data['warehouse_id'] = str_replace(',', '-',$this->session->userdata('warehouse_id'));
				$this->data['warehouse'] = $this->session->userdata('warehouse_id') ? $this->products_model->getUserWarehouses() : NULL;
			}
        }
		$this->data['agencies'] = $this->site->getAllUsers();

        $bc = array(array('link' => base_url(), 'page' => lang('home')), array('link' => '#', 'page' => lang('sales')));
        $meta = array('page_title' => lang('sales'), 'bc' => $bc);
        $this->page_construct('sales/index', $meta, $this->data);
    }
	
	function sales_loans(){
		//$this->erp->checkPermissions('loan', true, 'sales');
        $this->data['error'] = validation_errors() ? validation_errors() : $this->session->flashdata('error');

        $bc = array(array('link' => base_url(), 'page' => lang('home')), array('link' => site_url('sales'), 'page' => lang('sales')), array('link' => '#', 'page' => lang('list_loans')));
        $meta = array('page_title' => lang('list_loans'), 'bc' => $bc);
        $this->page_construct('sales/loans', $meta, $this->data);
	}
	
	function loan_actions(){
		if (!$this->Owner) {
            $this->session->set_flashdata('warning', lang('access_denied'));
            redirect($_SERVER["HTTP_REFERER"]);
        }

        $this->form_validation->set_rules('form_action', lang("form_action"), 'required');

        if ($this->form_validation->run() == true) {

            if (!empty($_POST['val'])) {
                if ($this->input->post('form_action') == 'delete') {
                    foreach ($_POST['val'] as $id) {
                        $this->sales_model->deleteSale($id);
                    }
                }
                
                if ($this->input->post('form_action') == 'combine_pay') {
                    //$html = $this->combine_pdf($_POST['val']);
                }

                if ($this->input->post('form_action') == 'export_excel' || $this->input->post('form_action') == 'export_pdf') {

                    $this->load->library('excel');
                    $this->excel->setActiveSheetIndex(0);
                    $this->excel->getActiveSheet()->setTitle(lang('sales'));
                    $this->excel->getActiveSheet()->SetCellValue('A1', lang('date'));
                    $this->excel->getActiveSheet()->SetCellValue('B1', lang('reference_no'));
                    $this->excel->getActiveSheet()->SetCellValue('C1', lang('shop'));
                    $this->excel->getActiveSheet()->SetCellValue('D1', lang('customer'));
					$this->excel->getActiveSheet()->SetCellValue('E1', lang('sale_status'));
                    $this->excel->getActiveSheet()->SetCellValue('F1', lang('grand_total'));
                    $this->excel->getActiveSheet()->SetCellValue('G1', lang('paid'));
					$this->excel->getActiveSheet()->SetCellValue('H1', lang('balance'));
                    $this->excel->getActiveSheet()->SetCellValue('I1', lang('payment_status'));

                    $row = 2;
                    foreach ($_POST['val'] as $id) {
                        $sale = $this->sales_model->getExportLoans($id);
                        $this->excel->getActiveSheet()->SetCellValue('A' . $row, $this->erp->hrld($sale->date));
                        $this->excel->getActiveSheet()->SetCellValue('B' . $row, $sale->ref_no);
                        $this->excel->getActiveSheet()->SetCellValue('C' . $row, $sale->biller);
                        $this->excel->getActiveSheet()->SetCellValue('D' . $row, $sale->customer);
                        $this->excel->getActiveSheet()->SetCellValue('E' . $row, $sale->sale_status);
                        $this->excel->getActiveSheet()->SetCellValue('F' . $row, $sale->grand_total);
                        $this->excel->getActiveSheet()->SetCellValue('G' . $row, $sale->paid);
						$this->excel->getActiveSheet()->SetCellValue('H' . $row, $sale->balance);
                        $this->excel->getActiveSheet()->SetCellValue('I' . $row, $sale->payment_status);
                        $row++;
                    }

                    $this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(20);
                    $this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
                    $this->excel->getDefaultStyle()->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                    $filename = 'sales_loans_' . date('Y_m_d_H_i_s');
                    if ($this->input->post('form_action') == 'export_pdf') {
                        $styleArray = array('borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN)));
                        $this->excel->getDefaultStyle()->applyFromArray($styleArray);
                        $this->excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
                        require_once(APPPATH . "third_party" . DIRECTORY_SEPARATOR . "MPDF" . DIRECTORY_SEPARATOR . "mpdf.php");
                        $rendererName = PHPExcel_Settings::PDF_RENDERER_MPDF;
                        $rendererLibrary = 'MPDF';
                        $rendererLibraryPath = APPPATH . 'third_party' . DIRECTORY_SEPARATOR . $rendererLibrary;
                        if (!PHPExcel_Settings::setPdfRenderer($rendererName, $rendererLibraryPath)) {
                            die('Please set the $rendererName: ' . $rendererName . ' and $rendererLibraryPath: ' . $rendererLibraryPath . ' values' .
                                PHP_EOL . ' as appropriate for your directory structure');
                        }

                        header('Content-Type: application/pdf');
                        header('Content-Disposition: attachment;filename="' . $filename . '.pdf"');
                        header('Cache-Control: max-age=0');

                        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'PDF');
                        return $objWriter->save('php://output');
                    }
                    if ($this->input->post('form_action') == 'export_excel') {
                        header('Content-Type: application/vnd.ms-excel');
                        header('Content-Disposition: attachment;filename="' . $filename . '.xls"');
                        header('Cache-Control: max-age=0');

                        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
                        return $objWriter->save('php://output');
                    }

                    redirect($_SERVER["HTTP_REFERER"]);
                }
            } else {
                $this->session->set_flashdata('error', lang("no_sale_selected"));
                redirect($_SERVER["HTTP_REFERER"]);
            }
        } else {
            $this->session->set_flashdata('error', validation_errors());
            redirect($_SERVER["HTTP_REFERER"]);
        }
	}
	
	function update_loan($id){
		 $payids=explode(':', $id);
		 foreach($payids as $payid){
			 echo $payid;
		 }
		
	}
	
	function getCustomerInfo(){
		$cus_id = $this->input->get('customer_id');
		$customer_info = $this->sales_model->getCustomerByID($cus_id);
        exit(json_encode($customer_info));
	}
	
	function assign_to_user($sale_id=NULL)
	{
		
		$this->form_validation->set_rules('user_id', lang("user_id"), 'required');
		$this->form_validation->set_rules('so_num', lang("so_num"), 'required');
		
        if ($this->form_validation->run() == true) {
			
              $user_id = $this->input->post('user_id');
			  $so_id   = $this->input->post('so_num');
			  $this->sales_model->assign_to_user($user_id,$so_id);
			  redirect("sales");
		}else{
			
		  	$this->erp->checkPermissions('index', TRUE);
			$this->data['AllUser']    = $this->Site->getAllUsers();
			$this->data['SO_NUM']     = $this->sales_model->getSalesById($sale_id);
 			//$this->data['document'] = $this->sales_model->getSalesById($sale_id);
			$this->load->view($this->theme . 'sales/assign_to_user', $this->data);
		}
	}
	
    /*===========================================chin local updated=======================================*/
	function getSales($warehouse_id = NULL)
    {
        $this->erp->checkPermissions('index', null, 'sales');
		if($warehouse_id){
			$warehouse_id = explode('-', $warehouse_id);
		}
		
		if ($this->input->get('user')) {
            $user_query = $this->input->get('user');
        } else {
            $user_query = NULL;
        }
        if ($this->input->get('reference_no')) {
            $reference_no = $this->input->get('reference_no');
        } else {
            $reference_no = NULL;
        }
        if ($this->input->get('customer')) {
            $customer = $this->input->get('customer');
        } else {
            $customer = NULL;
        }
		if ($this->input->get('saleman')) {
            $saleman = $this->input->get('saleman');
        } else {
            $saleman = NULL;
        }
		if ($this->input->get('product_id')) {
            $product_id = $this->input->get('product_id');
        } else {
            $product_id = NULL;
        }
        if ($this->input->get('biller')) {
            $biller = $this->input->get('biller');
        } else {
            $biller = NULL;
        }
		if ($this->input->get('warehouse')) {
            $warehouse = $this->input->get('warehouse');
        } else {
            $warehouse = NULL;
        }
		if ($this->input->get('payment_status')) {
            $payment_status = $this->input->get('payment_status');
        } else {
            $payment_status = NULL;
        }
        if ($this->input->get('start_date')) {
            $start_date = $this->input->get('start_date');
        } else {
            $start_date = NULL;
        }
        if ($this->input->get('end_date')) {
            $end_date = $this->input->get('end_date');
        } else {
            $end_date = NULL;
        }
		
        if ($start_date) {
            $start_date = $this->erp->fld($start_date);
            $end_date = $this->erp->fld($end_date);
        }

        if ((! $this->Owner || ! $this->Admin) && ! $warehouse_id) {
            //$user = $this->site->getUser();
            //$warehouse_id = $user->warehouse_id;
        }

        $detail_link = anchor('sales/view/$1', '<i class="fa fa-file-text-o"></i> ' . lang('sale_details'));
		$view_document = anchor('sales/view_document/$1', '<i class="fa fa-chain"></i> ' . lang('view_document'), 'data-toggle="modal" data-target="#myModal"');
        $payments_link = anchor('sales/payments/$1', '<i class="fa fa-money"></i> ' . lang('view_payments'), 'data-toggle="modal" data-target="#myModal"');
        $add_payment_link = anchor('sales/add_payment/$1', '<i class="fa fa-money"></i> ' . lang('add_payment'), 'data-toggle="modal" data-target="#myModal"');
        $add_delivery_link = anchor('sales/add_delivery/$1', '<i class="fa fa-truck"></i> ' . lang('add_delivery'), 'data-toggle="modal" data-target="#myModal"');
        $email_link = anchor('sales/email/$1', '<i class="fa fa-envelope"></i> ' . lang('email_sale'), 'data-toggle="modal" data-target="#myModal"');
        $assign_to  = anchor('sales/assign_to_user/$1', '<i class="fa fa-check"></i> ' . lang('assign_to_user'),'data-toggle="modal" data-target="#myModal"');
   	    $edit_link = anchor('sales/edit/$1', '<i class="fa fa-edit"></i> ' . lang('edit_sale'), 'class="sledit"');
        $pdf_link = anchor('sales/pdf/$1', '<i class="fa fa-file-pdf-o"></i> ' . lang('download_pdf'));
        $return_link = anchor('sales/return_sale/$1', '<i class="fa fa-angle-double-left"></i> ' . lang('return_sale'));
        $delete_link = "<a href='#' class='po' title='<b>" . lang("delete_sale") . "</b>' data-content=\"<p>"
            . lang('r_u_sure') . "</p><a class='btn btn-danger po-delete' href='" . site_url('sales/delete/$1') . "'>"
            . lang('i_m_sure') . "</a> <button class='btn po-close'>" . lang('no') . "</button>\"  rel='popover'><i class=\"fa fa-trash-o\"></i> "
            . lang('delete_sale') . "</a>";
        $action = '<div class="text-center"><div class="btn-group text-left">'
            . '<button type="button" class="btn btn-default btn-xs btn-primary dropdown-toggle" data-toggle="dropdown">'
            . lang('actions') . ' <span class="caret"></span></button>
        <ul class="dropdown-menu pull-right" role="menu">
            <li>' . $detail_link . '</li>
			<li>' . $view_document . '</li>
			<li>' . $cabon_print . '</li>
            <li>' . $payments_link . '</li>
			<li>' . $assign_to. '</li>
            <li>' . $add_payment_link . '</li>'
			
			.(($this->Owner || $this->Admin) ? '<li>'.$edit_link.'</li>' : ($this->GP['sales-edit'] ? '<li>'.$edit_link.'</li>' : '')).

            '<li>' . $pdf_link . '</li>
            <li>' . $return_link . '</li>
        </ul>
		</div></div>';
        //$action = '<div class="text-center">' . $detail_link . ' ' . $edit_link . ' ' . $email_link . ' ' . $delete_link . '</div>';
       // $permission = $this->site->getPermission();
        
       // echo $permission->product_edit;die();
        $this->load->library('datatables');
        if ($warehouse_id) {
            $this->datatables
                ->select("sales.id, sales.date, erp_quotes.reference_no as q_no,sale_order.reference_no as so_no, sales.reference_no as sale_no, sales.biller, sales.customer, users.username AS saleman, sales.sale_status, sales.grand_total,(SELECT SUM(IF(erp_payments.paid_by = 'deposit', erp_payments.amount, 0)) FROM erp_payments WHERE erp_payments.sale_id = erp_sales.id  ) as deposit, (erp_sales.paid - (SELECT SUM(IF(erp_payments.paid_by = 'deposit', erp_payments.amount, 0)) FROM erp_payments WHERE erp_payments.sale_id = erp_sales.id)), (erp_sales.grand_total-erp_sales.paid) as balance, sales.payment_status")
                ->from('sales')
				->join('companies', 'companies.id = sales.customer_id', 'left')
				->join('users', 'users.id = sales.saleman_by', 'left')
				->join('sale_order', 'sale_order.id = sales.so_id', 'left')
				->join('erp_quotes', 'erp_quotes.id = sales.quote_id', 'left')
                ->where_in('sales.warehouse_id', $warehouse_id);
        } else {
			$this->datatables
				->select("sales.id, sales.date,erp_quotes.reference_no as q_no, sale_order.reference_no as so_no, sales.reference_no as sale_no, sales.biller, sales.customer, users.username AS saleman, sales.sale_status, sales.grand_total, (SELECT SUM(IF(erp_payments.paid_by = 'deposit', erp_payments.amount, 0)) FROM erp_payments WHERE erp_payments.sale_id = erp_sales.id  ) as deposit, (erp_sales.paid - (SELECT SUM(IF(erp_payments.paid_by = 'deposit', erp_payments.amount, 0)) FROM erp_payments WHERE erp_payments.sale_id = erp_sales.id)), (erp_sales.grand_total-erp_sales.paid) as balance, sales.payment_status")
				->from('sales')
				->join('users', 'users.id = sales.saleman_by', 'left')
				->join('sale_order', 'sale_order.id = sales.so_id', 'left')
				->join('payments', 'payments.sale_id = sales.id', 'left')
				->join('erp_quotes', 'erp_quotes.id = sales.quote_id', 'left')
				->join('companies', 'companies.id = sales.customer_id', 'left');
			
			if(isset($_REQUEST['d'])){
				$date = $_GET['d'];
				$date1 = str_replace("/", "-", $date);
				$date =  date('Y-m-d', strtotime($date1));
				
				$this->datatables
						->where("date >=", $date)
						->where('DATE_SUB(date, INTERVAL 1 DAY) <= CURDATE()')
						->where('sales.payment_term <>', 0);
			}
			
        }
		if ($product_id) {
			$this->datatables->join('sale_items', 'sale_items.sale_id = sales.id', 'left');
			$this->datatables->where('sale_items.product_id', $product_id);
		}
		
        $this->datatables->where('sales.pos !=', 1);
		
        if (!$this->Customer && !$this->Supplier && !$this->Owner && !$this->Admin && !$this->session->userdata('view_right')) {
            $this->datatables->where('sales.created_by', $this->session->userdata('user_id'));
        } elseif ($this->Customer) {
            $this->datatables->where('customer_id', $this->session->userdata('user_id'));
        }
		
		if ($user_query) {
			$this->datatables->where('sales.created_by', $user_query);
		}
		if ($payment_status) {
			$get_status = explode('_', $payment_status);
			$this->datatables->where_in('sales.payment_status', $get_status);
		}
		if ($reference_no) {
			$this->datatables->where('sales.reference_no', $reference_no);
		}
		if ($biller) {
			$this->datatables->where('sales.biller_id', $biller);
		}
		if ($customer) {
			$this->datatables->where('sales.customer_id', $customer);
		}
		
		if($saleman){
			$this->datatables->where('sales.saleman_by', $saleman);
		}
		
		if ($warehouse) {
			$this->datatables->where('sales.warehouse_id', $warehouse);
		}

		if ($start_date) {
			$this->datatables->where($this->db->dbprefix('sales').'.date BETWEEN "' . $start_date . '" and "' . $end_date . '"');
		}
		
		$this->datatables->group_by('sales.id');
		
        $this->datatables->add_column("Actions", $action, "sales.id");
        echo $this->datatables->generate();
    }
	/*======================================end local updated=============================================*/
	
	//------------get pending sale && Pos partial--------
	function getSales_pending($warehouse_id = NULL, $dt = NULL)
    {
        $this->erp->checkPermissions('index');
		
		if ($this->input->get('user')) {
            $user_query = $this->input->get('user');
        } else {
            $user_query = NULL;
        }
        if ($this->input->get('reference_no')) {
            $reference_no = $this->input->get('reference_no');
        } else {
            $reference_no = NULL;
        }
        if ($this->input->get('customer')) {
            $customer = $this->input->get('customer');
        } else {
            $customer = NULL;
        }
        if ($this->input->get('biller')) {
            $biller = $this->input->get('biller');
        } else {
            $biller = NULL;
        }
		if ($this->input->get('warehouse')) {
            $warehouse = $this->input->get('warehouse');
        } else {
            $warehouse = NULL;
        }
        if ($this->input->get('start_date')) {
            $start_date = $this->input->get('start_date');
        } else {
            $start_date = NULL;
        }

        if ($this->input->get('search_id')) {
            $search_id = $this->input->get('search_id');
        } else {
            $search_id = NULL;
        }

        if ($this->input->get('end_date')) {
            $end_date = $this->input->get('end_date');
        } else {
            $end_date = NULL;
        }
        if ($start_date) {
            $start_date = $this->erp->fld($start_date);
            $end_date = $this->erp->fld($end_date);
        }

        if ((! $this->Owner || ! $this->Admin) && ! $warehouse_id) {
            $user = $this->site->getUser();
            $warehouse_id = $user->warehouse_id;
        }

        $detail_link = anchor('sales/view/$1', '<i class="fa fa-file-text-o"></i> ' . lang('sale_details'));
        $payments_link = anchor('sales/payments/$1', '<i class="fa fa-money"></i> ' . lang('view_payments'), 'data-toggle="modal" data-target="#myModal"');
        $add_payment_link = anchor('sales/add_payment/$1', '<i class="fa fa-money"></i> ' . lang('add_payment'), 'data-toggle="modal" data-target="#myModal"');
        $add_delivery_link = anchor('sales/add_delivery/$1', '<i class="fa fa-truck"></i> ' . lang('add_delivery'), 'data-toggle="modal" data-target="#myModal"');
        $email_link = anchor('sales/email/$1', '<i class="fa fa-envelope"></i> ' . lang('email_sale'), 'data-toggle="modal" data-target="#myModal"');
        $edit_link = anchor('sales/edit/$1', '<i class="fa fa-edit"></i> ' . lang('edit_sale'), 'class="sledit"');
        $pdf_link = anchor('sales/pdf/$1', '<i class="fa fa-file-pdf-o"></i> ' . lang('download_pdf'));
        $return_link = anchor('sales/return_sale/$1', '<i class="fa fa-angle-double-left"></i> ' . lang('return_sale'));
        $delete_link = "<a href='#' class='po' title='<b>" . lang("delete_sale") . "</b>' data-content=\"<p>"
            . lang('r_u_sure') . "</p><a class='btn btn-danger po-delete' href='" . site_url('sales/delete/$1') . "'>"
            . lang('i_m_sure') . "</a> <button class='btn po-close'>" . lang('no') . "</button>\"  rel='popover'><i class=\"fa fa-trash-o\"></i> "
            . lang('delete_sale') . "</a>";
        $action = '<div class="text-center"><div class="btn-group text-left">'
            . '<button type="button" class="btn btn-default btn-xs btn-primary dropdown-toggle" data-toggle="dropdown">'
            . lang('actions') . ' <span class="caret"></span></button>
        <ul class="dropdown-menu pull-right" role="menu">
            <li>' . $detail_link . '</li>
            <li>' . $payments_link . '</li>
            <li>' . $add_payment_link . '</li>
            <li>' . $pdf_link . '</li>
            <li>' . $email_link . '</li>
            <li>' . $return_link . '</li>
            
        </ul>
    </div></div>';
        //$action = '<div class="text-center">' . $detail_link . ' ' . $edit_link . ' ' . $email_link . ' ' . $delete_link . '</div>';
		
		
		
        $this->load->library('datatables');
        if ($warehouse_id) {
            $this->datatables
                ->select("id, date, reference_no, biller, customer, sale_status, grand_total, paid, (grand_total-paid) as balance, payment_status")
                ->from('sales')
				->where('payment_status !=', 'paid')
				->where('sale_status !=', 'returned')
                ->where('warehouse_id', $warehouse_id);
        } else {
			$this->datatables
			->select("id, date, reference_no, biller, customer, sale_status, grand_total, paid, (grand_total-paid) as balance, payment_status")
			->from('sales')
			->where('sale_status !=', 'returned')
			->where('payment_status !=', 'paid')
			->where('(grand_total-paid) <> ', 0);
			if(isset($_REQUEST['d'])){
				$date = $_GET['d'];
				$date1 = str_replace("/", "-", $date);
				$date =  date('Y-m-d', strtotime($date1));
				
				$this->datatables
				->where("date >=", $date)
				->where('DATE_SUB(date, INTERVAL 1 DAY) <= CURDATE()')
				->where('sales.payment_term <>', 0);
			}
        }
        //$this->datatables->where('pos !=', 1);
        if ($this->permission['sales-index'] = ''){
            if (!$this->Customer && !$this->Supplier && !$this->Owner && !$this->Admin) {
                $this->datatables->where('created_by', $this->session->userdata('user_id'));
            } elseif ($this->Customer) {
                $this->datatables->where('customer_id', $this->session->userdata('user_id'));
            }
        }
		
        if ($search_id) {
            $this->datatables->where('sales.id', $search_id);
        }

		if ($user_query) {
			$this->datatables->where('sales.created_by', $user_query);
		}/*
		if ($customer) {
			$this->datatables->where('sales.id', $customer);
		}*/
		if ($reference_no) {
			$this->datatables->where('sales.reference_no', $reference_no);
		}
		if ($biller) {
			$this->datatables->where('sales.biller_id', $biller);
		}
		if ($customer) {
			$this->datatables->where('sales.customer_id', $customer);
		}
		if ($warehouse) {
			$this->datatables->where('sales.warehouse_id', $warehouse);
		}

		if ($start_date) {
			$this->datatables->where($this->db->dbprefix('sales').'.date BETWEEN "' . $start_date . '" and "' . $end_date . '"');
		}
		
		if($dt == 30){
			$this->datatables->where('date('. $this->db->dbprefix('sales') .'.date) > CURDATE() AND date('. $this->db->dbprefix('sales') .'.date) <= DATE_ADD(now(), INTERVAL + 30 DAY)');
		}elseif($dt == 60){
			$this->datatables->where('date('. $this->db->dbprefix('sales') .'.date) > DATE_ADD(now(), INTERVAL + 30 DAY) AND date('. $this->db->dbprefix('sales') .'.date) <= DATE_ADD(now(), INTERVAL + 60 DAY)');
		}elseif($dt == 90){
			$this->datatables->where('date('. $this->db->dbprefix('sales') .'.date) > DATE_ADD(now(), INTERVAL + 60 DAY) AND date('. $this->db->dbprefix('sales') .'.date) <= DATE_ADD(now(), INTERVAL + 90 DAY)');
		}elseif($dt == 91){
			$this->datatables->where('date('. $this->db->dbprefix('sales') .'.date) >= DATE_ADD(now(), INTERVAL + 90 DAY)');
		}
		
        $this->datatables->add_column("Actions", $action, "id");
        echo $this->datatables->generate();
    }
	function customer_balance(){
		//$this->erp->checkPermissions('customer',NULL,'sale_report');
        $this->data['error'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('error');
		$this->data['customers'] = $this->site->getCustomerSale();
		//$this->data['billers'] = $this->site->getAllCompanies('biller');
		//$this->data['users'] = $this->site->getStaff();
		//$this->data['warehouses'] = $this->site->getAllWarehouses();
        $bc = array(array('link' => base_url(), 'page' => lang('home')), array('link' => site_url('sales'), 'page' => lang('sales')), array('link' => '#', 'page' => lang('customers_balance')));
        $meta = array('page_title' => lang('customers_balance'), 'bc' => $bc);
        $this->page_construct('sales/customer_balance', $meta, $this->data);
	}
	function combine_payment_customer()
    {
        $this->erp->checkPermissions('payments', true);
        $this->load->helper('security');
        $arr = array();
        
        if ($this->input->get('data'))
        {
            $arr = explode(',', $this->input->get('data'));
        }
        
        //$this->form_validation->set_rules('reference_no', lang("reference_no"), 'required');
        $this->form_validation->set_rules('amount-paid', lang("amount"), 'required');
        $this->form_validation->set_rules('paid_by', lang("paid_by"), 'required');
        $this->form_validation->set_rules('userfile', lang("attachment"), 'xss_clean');
        if ($this->form_validation->run() == true) {
            if ($this->Owner || $this->Admin) {
                $date = $this->erp->fld(trim($this->input->post('date')));
            } else {
                $date = date('Y-m-d H:i:s');
            }
            
            if ($_FILES['userfile']['size'] > 0) {
                $this->load->library('upload');
                $config['upload_path'] = $this->upload_path;
                $config['allowed_types'] = $this->digital_file_types;
                $config['max_size'] = $this->allowed_file_size;
                $config['overwrite'] = FALSE;
                $config['encrypt_name'] = TRUE;
                $this->upload->initialize($config);
                if (!$this->upload->do_upload()) {
                    $error = $this->upload->display_errors();
                    $this->session->set_flashdata('error', $error);
                    redirect($_SERVER["HTTP_REFERER"]);
                }
                $photo = $this->upload->file_name;
                //$payment['attachment'] = $photo;
            }
			$sale_id_arr = $this->input->post('sale_id');
			$amount_paid_arr = $this->input->post('amount_paid_line');
			$i = 0;
			$reference_no = $this->input->post('reference_no') ? $this->input->post('reference_no') : $this->site->getReference('sp');
			foreach($sale_id_arr as $sale_id){
			
				$payment = array(
					'date' => $date,
					'sale_id' => $sale_id,
					'reference_no' => $reference_no,
					'amount' => $amount_paid_arr[$i],
					'paid_by' => $this->input->post('paid_by'),
					'cheque_no' => $this->input->post('cheque_no'),
					'cc_no' => $this->input->post('paid_by') == 'gift_card' ? $this->input->post('gift_card_no') : $this->input->post('pcc_no'),
					'cc_holder' => $this->input->post('pcc_holder'),
					'cc_month' => $this->input->post('pcc_month'),
					'cc_year' => $this->input->post('pcc_year'),
					'cc_type' => $this->input->post('pcc_type'),
					'note' => $this->input->post('note'),
					'created_by' => $this->session->userdata('user_id'),
					'type' => 'received',
					'biller_id'	=> $this->input->post('biller'),
					'attachment' =>$photo
				);
				$this->sales_model->addPayment($payment);
				$i++;
			}
			
            //$this->erp->print_arrays($payment);
			$this->session->set_flashdata('message', lang("payment_added"));
            redirect($_SERVER["HTTP_REFERER"]);

        } else{
			$this->data['error'] = (validation_errors() ? validation_errors() : $this->session->flashdata('error'));
			$this->data['billers'] = $this->site->getAllCompanies('biller');
            $combine_payment = $this->sales_model->getCombinePaymentById($arr);
            $this->data['combine_sales'] = $combine_payment;
            $this->data['payment_ref'] = ''; //$this->site->getReference('sp');
            $this->data['modal_js'] = $this->site->modal_js();

            $this->load->view($this->theme . 'sales/combine_payment_customer', $this->data);
		}
    }
	function getCustomerBalance()
    {
		if ($this->input->get('customer')) {
            $customer = $this->input->get('customer');
        } else {
            $customer = NULL;
        }
		if ($this->input->get('start_date')) {
            $start_date = $this->input->get('start_date');
        } else {
            $start_date = NULL;
        }

        if ($this->input->get('end_date')) {
            $end_date = $this->input->get('end_date');
        } else {
            $end_date = NULL;
        }
        if ($start_date) {
            $start_date = $this->erp->fld($start_date);
            $end_date = $this->erp->fld($end_date);
        }
		$this->load->library('datatables');
		$this->datatables
			/*->select('id, code, name, phone, email, address')
			->from('erp_companies')
			->where('companies.group_name = ', 'customer')
			->add_column("Actions", "<div class='text-center'><a class=\"tip\" title='" . lang("view_report") . "' href='" . site_url('reports/customer_sale_report/$1') . "'><span class='label label-primary'>" . lang("view_report") . "</span></a></div>", "id");
			*/
			
			->select($this->db->dbprefix('companies') . ".id as idd, company, name, phone, email, count(" . $this->db->dbprefix('sales') . ".id) as total, COALESCE(sum(grand_total), 0) as total_amount, COALESCE(sum(paid), 0) as paid, ( COALESCE(sum(grand_total), 0) - COALESCE(sum(paid), 0)) as balance", FALSE)
                ->from("companies")
                ->join('sales', 'sales.customer_id = companies.id', 'left')
                ->where(array('companies.group_name' => 'customer', 'payment_status <>' => 'paid'))
				->group_by('companies.id');
		if ($customer) {
            $this->datatables->where('companies.id', $customer);
        }
		if ($start_date) {
			$this->datatables->where($this->db->dbprefix('sales').'.date BETWEEN "' . $start_date . '" and "' . $end_date . '"');
		}
        $this->datatables->add_column("Actions", "<div class='text-center'><a class=\"tip\" title='" . lang("view_balance") . "' href='" . site_url('sales/view_customer_balance/$1') . "'><span class='label label-primary'>" . lang("view_balance") . "</span></a></div>", "idd");
                //->unset_column('id');
			
		echo $this->datatables->generate();
    }
	function view_customer_balance($user_id = NULL) {
		//$this->erp->checkPermissions('customers', TRUE);
        if (!$user_id && $_GET['d'] == null) {
            //$this->session->set_flashdata('error', lang("no_customer_selected"));
            redirect($_SERVER["HTTP_REFERER"]);
        }	
        $this->data['error'] = validation_errors() ? validation_errors() : $this->session->flashdata('error');
		$this->data['date'] = $date;
        $this->data['user_id'] = $user_id;
		$this->data['billers'] = $this->site->getAllCompanies('biller');
        $bc = array(array('link' => base_url(), 'page' => lang('home')), array('link' => site_url('reports'), 'page' => lang('reports')), array('link' => '#', 'page' => lang('customer_balance')));
        $meta = array('page_title' => lang('customer_balance'), 'bc' => $bc);
        $this->page_construct('sales/view_customer_balance', $meta, $this->data);
	}
	function customer_balance_actions()
	{
		if (!$this->Owner) {
			$this->session->set_flashdata('warning', lang('access_denied'));
			redirect($_SERVER["HTTP_REFERER"]);
		}

		$this->form_validation->set_rules('form_action', lang("form_action"), 'required');

		if ($this->form_validation->run() == true) {

			if (!empty($_POST['val'])) {
				if ($this->input->post('form_action') == 'delete') {
					
					$error = false;
					foreach ($_POST['val'] as $id) {
						if (!$this->accounts_model->deleteChartAccount($id)) {
							$error = true;
						}
					}
					if ($error) {
						$this->session->set_flashdata('warning', lang('suppliers_x_deleted_have_purchases'));
					} else {
						$this->session->set_flashdata('message', $this->lang->line("account_deleted_successfully"));
					}
					redirect($_SERVER["HTTP_REFERER"]);
				}

				if ($this->input->post('form_action') == 'export_excel' || $this->input->post('form_action') == 'export_pdf') {

					$this->load->library('excel');
					$this->excel->setActiveSheetIndex(0);
					$this->excel->getActiveSheet()->setTitle(lang('acc_receivable'));
					$this->excel->getActiveSheet()->SetCellValue('A1', lang('date'));
					$this->excel->getActiveSheet()->SetCellValue('B1', lang('reference_no'));
					$this->excel->getActiveSheet()->SetCellValue('C1', lang('shop'));
					$this->excel->getActiveSheet()->SetCellValue('D1', lang('customer'));
					$this->excel->getActiveSheet()->SetCellValue('E1', lang('sale_status'));
					$this->excel->getActiveSheet()->SetCellValue('F1', lang('grand_total'));
					$this->excel->getActiveSheet()->SetCellValue('G1', lang('paid'));
					$this->excel->getActiveSheet()->SetCellValue('H1', lang('balance'));
					$this->excel->getActiveSheet()->SetCellValue('I1', lang('payment_status'));

					$row = 2;
					foreach ($_POST['val'] as $id) {
						$account = $this->site->getReceivableByID($id);
						$this->excel->getActiveSheet()->SetCellValue('A' . $row, $account->date);
						$this->excel->getActiveSheet()->SetCellValue('B' . $row, $account->reference_no);
						$this->excel->getActiveSheet()->SetCellValue('C' . $row, $account->biller);
						$this->excel->getActiveSheet()->SetCellValue('D' . $row, $account->customer);
						$this->excel->getActiveSheet()->SetCellValue('E' . $row, $account->sale_status);
						$this->excel->getActiveSheet()->SetCellValue('F' . $row, $account->grand_total);
						$this->excel->getActiveSheet()->SetCellValue('G' . $row, $account->paid);
						$this->excel->getActiveSheet()->SetCellValue('H' . $row, $account->balance);
						$this->excel->getActiveSheet()->SetCellValue('I' . $row, $account->payment_status);
						$row++;
					}

					$this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(20);
					$this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
					$this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
					$this->excel->getDefaultStyle()->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
					$filename = 'Acc_Receivable_' . date('Y_m_d_H_i_s');
					if ($this->input->post('form_action') == 'export_pdf') {
						$styleArray = array('borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN)));
						$this->excel->getDefaultStyle()->applyFromArray($styleArray);
						$this->excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
						require_once(APPPATH . "third_party" . DIRECTORY_SEPARATOR . "MPDF" . DIRECTORY_SEPARATOR . "mpdf.php");
						$rendererName = PHPExcel_Settings::PDF_RENDERER_MPDF;
						$rendererLibrary = 'MPDF';
						$rendererLibraryPath = APPPATH . 'third_party' . DIRECTORY_SEPARATOR . $rendererLibrary;
						if (!PHPExcel_Settings::setPdfRenderer($rendererName, $rendererLibraryPath)) {
							die('Please set the $rendererName: ' . $rendererName . ' and $rendererLibraryPath: ' . $rendererLibraryPath . ' values' .
								PHP_EOL . ' as appropriate for your directory structure');
						}

						header('Content-Type: application/pdf');
						header('Content-Disposition: attachment;filename="' . $filename . '.pdf"');
						header('Cache-Control: max-age=0');

						$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'PDF');
						return $objWriter->save('php://output');
					}
					if ($this->input->post('form_action') == 'export_excel') {
						header('Content-Type: application/vnd.ms-excel');
						header('Content-Disposition: attachment;filename="' . $filename . '.xls"');
						header('Cache-Control: max-age=0');

						$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
						return $objWriter->save('php://output');
					}

					redirect($_SERVER["HTTP_REFERER"]);
				}
			} else {
				$this->session->set_flashdata('error', $this->lang->line("no_supplier_selected"));
				redirect($_SERVER["HTTP_REFERER"]);
			}
		} else {
			$this->session->set_flashdata('error', validation_errors());
			redirect($_SERVER["HTTP_REFERER"]);
		}
	}
	function getSales_DuePayment($warehouse_id = NULL, $dt = NULL)
    {
        $this->erp->checkPermissions('index');
		
		if ($this->input->get('reference_no')) {
            $reference_no = $this->input->get('reference_no');
        } else {
            $reference_no = NULL;
        }
        if ($this->input->get('biller')) {
            $biller = $this->input->get('biller');
        } else {
            $biller = NULL;
        }
        if ($this->input->get('start_date')) {
            $start_date = $this->input->get('start_date');
        } else {
            $start_date = NULL;
        }

        if ($this->input->get('end_date')) {
            $end_date = $this->input->get('end_date');
        } else {
            $end_date = NULL;
        }
        if ($start_date) {
            $start_date = $this->erp->fld($start_date);
            $end_date = $this->erp->fld($end_date);
        }
		if ($this->input->get('search_id')) {
            $search_id = $this->input->get('search_id');
        } else {
            $search_id = NULL;
        }
        if ((! $this->Owner || ! $this->Admin) && ! $warehouse_id) {
            $user = $this->site->getUser();
            $warehouse_id = $user->warehouse_id;
        }

        $detail_link = anchor('sales/view/$1', '<i class="fa fa-file-text-o"></i> ' . lang('sale_details'));
        $payments_link = anchor('sales/payments/$1', '<i class="fa fa-money"></i> ' . lang('view_payments'), 'data-toggle="modal" data-target="#myModal"');
        $add_payment_link = anchor('sales/add_payment/$1', '<i class="fa fa-money"></i> ' . lang('add_payment'), 'data-toggle="modal" data-target="#myModal"');
        $add_delivery_link = anchor('sales/add_delivery/$1', '<i class="fa fa-truck"></i> ' . lang('add_delivery'), 'data-toggle="modal" data-target="#myModal"');
        $email_link = anchor('sales/email/$1', '<i class="fa fa-envelope"></i> ' . lang('email_sale'), 'data-toggle="modal" data-target="#myModal"');
        $edit_link = anchor('sales/edit/$1', '<i class="fa fa-edit"></i> ' . lang('edit_sale'), 'class="sledit"');
        $pdf_link = anchor('sales/pdf/$1', '<i class="fa fa-file-pdf-o"></i> ' . lang('download_pdf'));
        $delete_link = "<a href='#' class='po' title='<b>" . lang("delete_sale") . "</b>' data-content=\"<p>"
            . lang('r_u_sure') . "</p><a class='btn btn-danger po-delete' href='" . site_url('sales/delete/$1') . "'>"
            . lang('i_m_sure') . "</a> <button class='btn po-close'>" . lang('no') . "</button>\"  rel='popover'><i class=\"fa fa-trash-o\"></i> "
            . lang('delete_sale') . "</a>";
        $action = '<div class="text-center"><div class="btn-group text-left">'
            . '<button type="button" class="btn btn-default btn-xs btn-primary dropdown-toggle" data-toggle="dropdown">'
            . lang('actions') . ' <span class="caret"></span></button>
        <ul class="dropdown-menu pull-right" role="menu">
            <li>' . $detail_link . '</li>
            <li>' . $payments_link . '</li>
            <li>' . $add_payment_link . '</li>
            <li>' . $pdf_link . '</li>
            <li>' . $email_link . '</li>            
        </ul>
    </div></div>';
        //$action = '<div class="text-center">' . $detail_link . ' ' . $edit_link . ' ' . $email_link . ' ' . $delete_link . '</div>';
		
		
		
        $this->load->library('datatables');
        if ($warehouse_id) {
            $this->datatables
                ->select("id, date, reference_no, biller, customer, sale_status, grand_total, paid, (grand_total-paid) as balance, payment_status")
                ->from('sales')
				->where('payment_status !=', 'paid')
				->where('sale_status !=', 'returned')
                ->where('warehouse_id', $warehouse_id);
        } else {
			$this->datatables
			->select("id, date, reference_no, biller, customer, sale_status, grand_total, paid, (grand_total-paid) as balance, payment_status")
			->from('sales')
			->where('sale_status !=', 'returned')
			->where('payment_status !=', 'paid')
			->where('(grand_total-paid) <> ', 0);
			if(isset($_REQUEST['d'])){
				$date = $_GET['d'];
				$date1 = str_replace("/", "-", $date);
				$date =  date('Y-m-d', strtotime($date1));
				
				$this->datatables
				->where("date >=", $date)
				->where('DATE_SUB(date, INTERVAL 1 DAY) <= CURDATE()')
				->where('sales.payment_term <>', 0);
			}
        }
        //$this->datatables->where('pos !=', 1);
        if ($this->permission['sales-index'] = ''){
            if (!$this->Customer && !$this->Supplier && !$this->Owner && !$this->Admin) {
                $this->datatables->where('created_by', $this->session->userdata('user_id'));
            } elseif ($this->Customer) {
                $this->datatables->where('customer_id', $this->session->userdata('user_id'));
            }
        }
		
		
		if ($reference_no) {
			$this->datatables->where('sales.reference_no', $reference_no);
		}
		if ($biller) {
			
			$this->datatables->where('sales.biller_id', $biller);
		}
		if ($start_date) {
			$this->datatables->where($this->db->dbprefix('sales').'.date BETWEEN "' . $start_date . '" and "' . $end_date . '"');
		}
		
		if($dt == 30){
			$this->datatables->where('date('. $this->db->dbprefix('sales') .'.date) > CURDATE() AND date('. $this->db->dbprefix('sales') .'.date) <= DATE_ADD(now(), INTERVAL + 30 DAY)');
		}elseif($dt == 60){
			$this->datatables->where('date('. $this->db->dbprefix('sales') .'.date) > DATE_ADD(now(), INTERVAL + 30 DAY) AND date('. $this->db->dbprefix('sales') .'.date) <= DATE_ADD(now(), INTERVAL + 60 DAY)');
		}elseif($dt == 90){
			$this->datatables->where('date('. $this->db->dbprefix('sales') .'.date) > DATE_ADD(now(), INTERVAL + 60 DAY) AND date('. $this->db->dbprefix('sales') .'.date) <= DATE_ADD(now(), INTERVAL + 90 DAY)');
		}elseif($dt == 91){
			$this->datatables->where('date('. $this->db->dbprefix('sales') .'.date) >= DATE_ADD(now(), INTERVAL + 90 DAY)');
		}
		
        $this->datatables->add_column("Actions", $action, "id");
        echo $this->datatables->generate();
    }
    function getCusDetails(){
		$customer_id = $this->input->get('customer_id');
		$row= $this->sales_model->getCusDetail($customer_id);
		echo json_encode($row);
	} 
	function return_sales($warehouse_id = NULL)
    {
        $this->erp->checkPermissions();

        $this->data['error'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('error');
        if ($this->Owner || $this->Admin || !$this->session->userdata('warehouse_id')) {
            $this->data['warehouses'] = $this->site->getAllWarehouses();
            $this->data['warehouse_id'] = $warehouse_id;
            $this->data['warehouse'] = $warehouse_id ? $this->site->getWarehouseByID($warehouse_id) : NULL;
			
        } else {
			
            $this->data['warehouses'] = $this->products_model->getUserWarehouses();
			if($warehouse_id){
				$this->data['warehouse_id'] = $warehouse_id;
				$this->data['warehouse'] = $warehouse_id ? $this->site->getWarehouseByID($warehouse_id) : NULL;
			}else{
				$this->data['warehouse_id'] = str_replace(',', '-',$this->session->userdata('warehouse_id'));
				$this->data['warehouse'] = $this->session->userdata('warehouse_id') ? $this->products_model->getUserWarehouses() : NULL;
			}
        }

        $bc = array(array('link' => base_url(), 'page' => lang('home')), array('link' => '#', 'page' => lang('return_sales')));
        $meta = array('page_title' => lang('return_sales'), 'bc' => $bc);
        $this->page_construct('sales/return_sales', $meta, $this->data);
    }

    function getReturns($warehouse_id = NULL)
    {
        $this->erp->checkPermissions('return_sales');
		if($warehouse_id){
			$warehouse_id = explode('-', $warehouse_id);
		}
		
        if (!$this->Owner && !$warehouse_id) {
            //$user = $this->site->getUser();
            //$warehouse_id = $user->warehouse_id;
        }
        $detail_link = anchor('sales/view/$1', '<i class="fa fa-file-text-o"></i>');
        $edit_link = ''; //anchor('sales/edit/$1', '<i class="fa fa-edit"></i>', 'class="reedit"');
        $delete_link = "<a href='#' class='po' title='<b>" . lang("delete_return_sale") . "</b>' data-content=\"<p>"
            . lang('r_u_sure') . "</p><a class='btn btn-danger po-delete' href='" . site_url('sales/delete_return/$1') . "'>"
            . lang('i_m_sure') . "</a> <button class='btn po-close'>" . lang('no') . "</button>\"  rel='popover'><i class=\"fa fa-trash-o\"></i></a>";
        $action = '<div class="text-center">' . $detail_link . ' ' . $edit_link . ' ' . $delete_link . '</div>';
        //$action = '<div class="text-center">' . $detail_link . ' ' . $edit_link . ' ' . $email_link . ' ' . $delete_link . '</div>';

        $this->load->library('datatables');
        if ($warehouse_id) {
            $this->datatables
                ->select($this->db->dbprefix('return_sales') . ".id as id," . $this->db->dbprefix('return_sales') . ".date as date, " . $this->db->dbprefix('return_sales') . ".reference_no as ref, (
						CASE
						WHEN erp_return_sales.sale_id > 0 THEN
							erp_sales.reference_no
						ELSE
							(
								SELECT
									GROUP_CONCAT(s.reference_no SEPARATOR '\r\n')
								FROM
									erp_return_items ri
								INNER JOIN erp_return_sales rs ON rs.id = ri.return_id
								LEFT JOIN erp_sales s ON s.id = ri.sale_id
								WHERE
									ri.return_id = erp_return_sales.id
							)
						END
					) AS sale_ref," . $this->db->dbprefix('return_sales') . ".biller, " . $this->db->dbprefix('return_sales') . ".customer, " . $this->db->dbprefix('return_sales') . ".surcharge, " . $this->db->dbprefix('return_sales') . ".grand_total, " . $this->db->dbprefix('return_sales') . ".paid, (" . $this->db->dbprefix('return_sales') . ".grand_total - " . $this->db->dbprefix('return_sales') . ".paid)")
                ->join('sales', 'sales.id=return_sales.sale_id', 'left')
				->join('return_items', 'return_items.return_id = return_sales.id', 'left')
                ->from('return_sales')
                ->group_by('return_sales.id')
                ->where_in('return_sales.warehouse_id', $warehouse_id);
        } else {
			/*
            $this->datatables
                ->select($this->db->dbprefix('return_sales') . ".date as date, " . $this->db->dbprefix('return_sales') . ".reference_no as ref, " . $this->db->dbprefix('sales') . ".reference_no as sal_ref, " . $this->db->dbprefix('return_sales') . ".biller, " . $this->db->dbprefix('return_sales') . ".customer, " . $this->db->dbprefix('return_sales') . ".surcharge, " . $this->db->dbprefix('return_sales') . ".grand_total, " . $this->db->dbprefix('return_sales') . ".id as id")
                ->join('sales', 'sales.id=return_sales.sale_id', 'left')
                ->from('return_sales')
                ->group_by('return_sales.id');
			*/
			$this->datatables
                ->select($this->db->dbprefix('return_sales') . ".id as id," . $this->db->dbprefix('return_sales') . ".date as date, " . $this->db->dbprefix('return_sales') . ".reference_no as ref, 
							(
								CASE
								WHEN erp_return_sales.sale_id > 0 THEN
									erp_sales.reference_no
								ELSE
									(
										SELECT
											GROUP_CONCAT(s.reference_no SEPARATOR '\r\n')
										FROM
											erp_return_items ri
										INNER JOIN erp_return_sales rs ON rs.id = ri.return_id
										LEFT JOIN erp_sales s ON s.id = ri.sale_id
										WHERE
											ri.return_id = erp_return_sales.id
									)
								END
							) AS sale_ref,
						" . $this->db->dbprefix('return_sales') . ".biller, " . $this->db->dbprefix('return_sales') . ".customer, " . $this->db->dbprefix('return_sales') . ".surcharge, " . $this->db->dbprefix('return_sales') . ".grand_total, " . $this->db->dbprefix('return_sales') . ".paid, (" . $this->db->dbprefix('return_sales') . ".grand_total - " . $this->db->dbprefix('return_sales') . ".paid)")
                ->join('sales', 'sales.id=return_sales.sale_id', 'left')
				->join('return_items', 'return_items.return_id = return_sales.id', 'left')
                ->from('return_sales')
                ->group_by('return_sales.id');
        }
		
		if (!$this->Customer && !$this->Supplier && !$this->Owner && !$this->Admin && !$this->session->userdata('view_right')) {
            $this->datatables->where('return_sales.created_by', $this->session->userdata('user_id'));
        } elseif ($this->Customer) {
            $this->datatables->where('customer_id', $this->session->userdata('user_id'));
        }
		
		if ($user_query) {
			$this->datatables->where('return_sales.created_by', $user_query);
		}
		
       
        $this->datatables->add_column("Actions", $action, "id");
        echo $this->datatables->generate();
    }
    
    function checkReturn($id){
        if($id){
            $isReturn = $this->sales_model->getReturnSaleBySaleID($id);
            if($isReturn){
                echo true;
            }else{
                echo false;
            }
        }
    }

    function modal_view_ar($id = NULL, $type = NULL){
        $this->erp->checkPermissions('index', TRUE);

        if ($this->input->get('id')) {
            $id = $this->input->get('id');
        }
        $this->load->model('pos_model');
        $this->data['pos'] = $this->pos_model->getSetting();
        $this->data['error'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('error');
        $inv = $this->sales_model->getInvoiceByID($id);
        $this->erp->view_rights($inv->created_by, TRUE);
        $this->data['customer'] = $this->site->getCompanyByID($inv->customer_id);
        $this->data['biller'] = $this->site->getCompanyByID($inv->biller_id);
        $this->data['created_by'] = $this->site->getUser($inv->created_by);
        $this->data['updated_by'] = $inv->updated_by ? $this->site->getUser($inv->updated_by) : NULL;
        $this->data['warehouse'] = $this->site->getWarehouseByID($inv->warehouse_id);
        $this->data['inv'] = $inv;
        $return = $this->sales_model->getReturnBySID($id);
        $this->data['return_sale'] = $return;
        $this->data['rows'] = $this->sales_model->getAllInvoiceItems($id);
        $this->data['cust_id'] = $inv->customer_id;
        $this->data['type_view'] = $type;

        $this->load->view($this->theme.'sales/modal_view_ar_aping', $this->data);
    }
	
	function modal_view($id = NULL)
    {
		
        $this->erp->checkPermissions('index', null, 'sales');	
        if ($this->input->get('id')) {
            $id = $this->input->get('id');
        }
		$this->load->model('pos_model');
		$this->data['pos'] = $this->pos_model->getSetting();
		$this->data['setting'] = $this->site->get_setting();
        $this->data['error'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('error');
        $inv = $this->sales_model->getInvoiceByID($id);
		if (!$this->session->userdata('view_right')) {
            $this->erp->view_rights($inv->created_by, true);
        }
        $this->data['customer'] = $this->site->getCompanyByID($inv->customer_id);
        $this->data['biller'] = $this->site->getCompanyByID($inv->biller_id);
        $this->data['created_by'] = $this->site->getUser($inv->created_by);
        $this->data['updated_by'] = $inv->updated_by ? $this->site->getUser($inv->updated_by) : NULL;
        $this->data['warehouse'] = $this->site->getWarehouseByID($inv->warehouse_id);
        $this->data['inv'] = $inv;
        $return = $this->sales_model->getReturnBySID($id);
        $this->data['return_sale'] = $return;
        $this->data['rows'] = $this->sales_model->getAllInvoiceItems($id);

        $this->load->view($this->theme.'sales/modal_view', $this->data);
    }
	

    function modal_view_old($id = NULL)
    {
        $this->erp->checkPermissions('index', TRUE);

        if ($this->input->get('id')) {
            $id = $this->input->get('id');
        }
		$this->load->model('pos_model');
		$this->data['pos'] = $this->pos_model->getSetting();
		$this->data['setting'] = $this->site->get_setting();
        $this->data['error'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('error');
        $inv = $this->sales_model->getInvoiceByID($id);
        //$this->erp->view_rights($inv->created_by, TRUE);
        $this->data['customer'] = $this->site->getCompanyByID($inv->customer_id);
        $this->data['biller'] = $this->site->getCompanyByID($inv->biller_id);
        $this->data['created_by'] = $this->site->getUser($inv->created_by);
        $this->data['updated_by'] = $inv->updated_by ? $this->site->getUser($inv->updated_by) : NULL;
        $this->data['warehouse'] = $this->site->getWarehouseByID($inv->warehouse_id);
        $this->data['inv'] = $inv;
        $return = $this->sales_model->getReturnBySID($id);
        $this->data['return_sale'] = $return;
        $this->data['rows'] = $this->sales_model->getAllInvoiceItems($id);

        $this->load->view($this->theme.'sales/modal_view', $this->data);
    }
	
	function loan_view($id = NULL)
    {
        $this->erp->checkPermissions('index', TRUE);

        if ($this->input->get('id')) {
            $id = $this->input->get('id');
        }
        $this->data['error'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('error');
        //$list_loans = $this->sales_model->getLoansByID($id);
		$list_items = $this->sales_model->getItemsByID($id);
		$sale_info = $this->sales_model->getSaleInfoByID($id);
		//$loan_view1 = $this->sales_model->getLoanView($id);
		$month_ = $this->sales_model->getMonths($id);
		$balance = $loan_view1->balance + $loan_view1->principle;
		$curr_interest = $this->sales_model->getCurrentInterestByMonth();
		$this->data['current_interest'] = $curr_interest;
		$this->data['list_items'] = $list_items;
		$this->data['sale_info'] = $sale_info;
		$this->data['sale_id'] = $id;
		$this->data['balance'] = $balance;
		//$this->data['loan_row'] = $loan_view1;
		$this->data['month'] = $month_;
		$this->data['cust_info'] = $this->sales_model->getCustomerByID($sale_info->customer_id);
        $this->load->view($this->theme.'sales/loan_view', $this->data);
    }
	
	function list_loan_data($id = NULL)
	{
		$this->erp->checkPermissions('index');
		
		if ($this->input->get('id')) {
            $id = $this->input->get('id');
        }
		
        $this->load->library('datatables');
		$this->datatables
			->select("loans.id, loans.period, 
					 loans.interest, loans.principle, loans.payment, 
					 loans.balance, loans.dateline,loans.note,users.username,paid_date
					 ")
			->from('loans')
			->join('users','users.id=loans.created_by','LEFT')
			->where('sale_id=', $id);

        
        echo $this->datatables->generate();
	}
	
	function p_invoice($id = NULL)
    {
		$this->erp->checkPermissions('index');

        if ($this->input->get('id')) {
            $id = $this->input->get('id');
        }
		
		$this->load->model('pos_model');
		$this->data['pos'] = $this->pos_model->getSetting();
		
		$this->data['error'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('error');
        
		$inv = $this->sales_model->getInvoiceByID($id);
        $this->erp->view_rights($inv->created_by, TRUE);
        $this->data['customer'] = $this->site->getCompanyByID($inv->customer_id);
        $this->data['biller'] = $this->site->getCompanyByID($inv->biller_id);
        $this->data['created_by'] = $this->site->getUser($inv->created_by);
        $this->data['updated_by'] = $inv->updated_by ? $this->site->getUser($inv->updated_by) : NULL;
        $this->data['warehouse'] = $this->site->getWarehouseByID($inv->warehouse_id);
        $this->data['inv'] = $inv;
		$this->data['vattin'] = $this->site->getTaxRateByID($inv->order_tax_id);
        $return = $this->sales_model->getReturnBySID($id);
        $this->data['return_sale'] = $return;
        $this->data['rows'] = $this->sales_model->getAllInvoiceItems($id);
		$this->data['logo'] = true;
        $this->load->view($this->theme . 'sales/p_invoice', $this->data);
    }
	function tax_invoice($id = NULL)
    {
		$this->erp->checkPermissions('index');

        if ($this->input->get('id')) {
            $id = $this->input->get('id');
        }
		
		$this->load->model('pos_model');
		$this->data['pos'] = $this->pos_model->getSetting();
		
		$this->data['error'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('error');
        
		$inv = $this->sales_model->getInvoiceByID($id);
        $this->erp->view_rights($inv->created_by, TRUE);
        $this->data['customer'] = $this->site->getCompanyByID($inv->customer_id);
        $this->data['biller'] = $this->site->getCompanyByID($inv->biller_id);
        $this->data['created_by'] = $this->site->getUser($inv->created_by);
        $this->data['updated_by'] = $inv->updated_by ? $this->site->getUser($inv->updated_by) : NULL;
        $this->data['warehouse'] = $this->site->getWarehouseByID($inv->warehouse_id);
        $this->data['inv'] = $inv;
		$this->data['vattin'] = $this->site->getTaxRateByID($inv->order_tax_id);
        $return = $this->sales_model->getReturnBySID($id);
        $this->data['return_sale'] = $return;
        $this->data['rows'] = $this->sales_model->getAllInvoiceItems($id);
		$this->data['logo'] = true;
        $this->load->view($this->theme . 'sales/tax_invoice', $this->data);
    }
	function invoice($id = NULL)
    {
		$this->erp->checkPermissions('index');

        if ($this->input->get('id')) {
            $id = $this->input->get('id');
        }
		
		$this->load->model('pos_model');
		$this->data['pos'] = $this->pos_model->getSetting();
		
		$this->data['error'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('error');
        
		$inv = $this->sales_model->getInvoiceByID($id);
        $this->erp->view_rights($inv->created_by, TRUE);
        $this->data['customer'] = $this->site->getCompanyByID($inv->customer_id);
        $this->data['biller'] = $this->site->getCompanyByID($inv->biller_id);
        $this->data['created_by'] = $this->site->getUser($inv->created_by);
		$this->data['seller'] = $this->site->getUser($inv->saleman_by);
        $this->data['updated_by'] = $inv->updated_by ? $this->site->getUser($inv->updated_by) : NULL;
        $this->data['warehouse'] = $this->site->getWarehouseByID($inv->warehouse_id);
        $this->data['inv'] = $inv;
		$this->data['vattin'] = $this->site->getTaxRateByID($inv->order_tax_id);
        $return = $this->sales_model->getReturnBySID($id);
        $this->data['return_sale'] = $return;
        $this->data['rows'] = $this->sales_model->getAllInvoiceItems($id);
		$this->data['logo'] = true;
        $this->load->view($this->theme . 'sales/invoice', $this->data);
    }
	
	function print_receipt($id = NULL)
    {
		$this->erp->checkPermissions('index');

        if ($this->input->get('id')) {
            $id = $this->input->get('id');
        }
		
		$this->load->model('pos_model');
		$this->data['pos'] = $this->pos_model->getSetting();
		
		$this->data['error'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('error');
        
		$inv = $this->sales_model->getInvoiceByID($id);
        $this->erp->view_rights($inv->created_by, TRUE);
        $this->data['customer'] = $this->site->getCompanyByID($inv->customer_id);
        $this->data['biller'] = $this->site->getCompanyByID($inv->biller_id);
        $this->data['created_by'] = $this->site->getUser($inv->created_by);
		$this->data['cashier'] = $this->site->getUser($inv->saleman_by);
        $this->data['updated_by'] = $inv->updated_by ? $this->site->getUser($inv->updated_by) : NULL;
        $this->data['warehouse'] = $this->site->getWarehouseByID($inv->warehouse_id);
        $this->data['inv'] = $inv;
		$this->data['vattin'] = $this->site->getTaxRateByID($inv->order_tax_id);
        $return = $this->sales_model->getReturnBySID($id);
        $this->data['return_sale'] = $return;
        $this->data['rows'] = $this->sales_model->getAllInvoiceItems($id);
		$this->data['payment'] = $this->sales_model->getPaymentBySaleID($id);
		$this->data['logo'] = true;
        $this->load->view($this->theme . 'sales/print_receipt', $this->data);
    }
	
	function cash_receipt($id = NULL)
    {
		$this->erp->checkPermissions('index');

        if ($this->input->get('id')) {
            $id = $this->input->get('id');
        }
		
		$this->load->model('pos_model');
		$this->data['pos'] = $this->pos_model->getSetting();
		
		$this->data['error'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('error');
        
		$payment = $this->sales_model->getPaymentByID($id);		
        $inv = $this->sales_model->getInvoiceByID($payment->sale_id);
		$payments = $this->sales_model->getCurrentBalance($inv->id);
		$current_balance = $inv->grand_total;
		foreach($payments as $curr_pay) {
			if ($curr_pay->id < $id) {
				$current_balance -= $curr_pay->amount;
			}
		}
		
		$this->data['curr_balance'] = $current_balance;
        $this->data['biller'] = $this->site->getCompanyByID($inv->biller_id);
        $this->data['customer'] = $this->site->getCompanyByID($inv->customer_id);
        $this->data['inv'] = $inv;
        $this->data['payment'] = $payment;
        $this->data['page_title'] = $this->lang->line("payment_note");

		//$this->erp->print_arrays($payment);
		
        $this->load->view($this->theme . 'sales/cash_receipt', $this->data);
    }
	
	function invoice_landscap_a5($id = NULL)
    {
		$this->erp->checkPermissions('index');

        if ($this->input->get('id')) {
            $id = $this->input->get('id');
        }
		
		$this->load->model('pos_model');
		$this->data['pos'] = $this->pos_model->getSetting();
		
		$this->data['error'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('error');
        
		$inv = $this->sales_model->getInvoiceByID($id);
        $this->erp->view_rights($inv->created_by, TRUE);
        $this->data['customer'] = $this->site->getCompanyByID($inv->customer_id);
        $this->data['biller'] = $this->site->getCompanyByID($inv->biller_id);
        $this->data['created_by'] = $this->site->getUser($inv->created_by);
		$this->data['cashier'] = $this->site->getUser($inv->saleman_by);
        $this->data['updated_by'] = $inv->updated_by ? $this->site->getUser($inv->updated_by) : NULL;
        $this->data['warehouse'] = $this->site->getWarehouseByID($inv->warehouse_id);
        $this->data['inv'] = $inv;
		$this->data['vattin'] = $this->site->getTaxRateByID($inv->order_tax_id);
        $return = $this->sales_model->getReturnBySID($id);
        $this->data['return_sale'] = $return;
        $this->data['rows'] = $this->sales_model->getAllInvoiceItems($id);
		//$this->erp->print_arrays($this->sales_model->getAllInvoiceItems($id));
		$this->data['payment'] = $this->sales_model->getPaymentBySaleID($id);
		$this->data['logo'] = true;
        $this->load->view($this->theme . 'sales/invoice_landscap_a5', $this->data);
    }
	
	function invoice_poto($id = NULL)
    {
		$this->erp->checkPermissions('index');

        if ($this->input->get('id')) {
            $id = $this->input->get('id');
        }
		
		$this->load->model('pos_model');
		$this->data['pos'] = $this->pos_model->getSetting();
		
		$this->data['error'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('error');
        
		$inv = $this->sales_model->getInvoiceByID($id);
        $this->erp->view_rights($inv->created_by, TRUE);
        $this->data['customer'] = $this->site->getCompanyByID($inv->customer_id);
        $this->data['biller'] = $this->site->getCompanyByID($inv->biller_id);
        $this->data['created_by'] = $this->site->getUser($inv->created_by);
		$this->data['cashier'] = $this->site->getUser($inv->saleman_by);
        $this->data['updated_by'] = $inv->updated_by ? $this->site->getUser($inv->updated_by) : NULL;
        $this->data['warehouse'] = $this->site->getWarehouseByID($inv->warehouse_id);
        $this->data['inv'] = $inv;
		$this->data['vattin'] = $this->site->getTaxRateByID($inv->order_tax_id);
        $return = $this->sales_model->getReturnBySID($id);
        $this->data['return_sale'] = $return;
        $this->data['rows'] = $this->sales_model->getAllInvoiceItems($id);
		$this->data['payment'] = $this->sales_model->getPaymentBySaleID($id);
		$this->data['logo'] = true;
        $this->load->view($this->theme . 'sales/invoice_poto', $this->data);
    }

    function view($id = NULL)
    {
        $this->erp->checkPermissions('index');

        if ($this->input->get('id')) {
            $id = $this->input->get('id');
        }
		$this->load->model('pos_model');
		$this->data['pos'] = $this->pos_model->getSetting();
		$this->data['setting'] = $this->site->get_setting();
        $this->data['error'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('error');
        $inv = $this->sales_model->getInvoiceByID($id);
        $this->erp->view_rights($inv->created_by);
        $this->data['barcode'] = "<img src='" . site_url('products/gen_barcode/' . $inv->reference_no) . "' alt='" . $inv->reference_no . "' class='pull-left' />";
        $this->data['customer'] = $this->site->getCompanyByID($inv->customer_id);
        $this->data['payments'] = $this->sales_model->getPaymentsForSale($id);
        $this->data['biller'] = $this->site->getCompanyByID($inv->biller_id);
        $this->data['created_by'] = $this->site->getUser($inv->created_by);
        $this->data['updated_by'] = $inv->updated_by ? $this->site->getUser($inv->updated_by) : NULL;
        $this->data['warehouse'] = $this->site->getWarehouseByID($inv->warehouse_id);
        $this->data['inv'] = $inv;
        $return = $this->sales_model->getReturnBySID($id);
        $this->data['return_sale'] = $return;
        $this->data['rows'] = $this->sales_model->getAllInvoiceItems($id);
        //$this->data['return_items'] = $return ? $this->sales_model->getAllReturnItems($return->id) : NULL;
        $this->data['paypal'] = $this->sales_model->getPaypalSettings();
        $this->data['skrill'] = $this->sales_model->getSkrillSettings();

        $bc = array(array('link' => base_url(), 'page' => lang('home')), array('link' => site_url('sales'), 'page' => lang('sales')), array('link' => '#', 'page' => lang('view')));
        $meta = array('page_title' => lang('view_sales_details'), 'bc' => $bc);
        $this->page_construct('sales/view', $meta, $this->data);
    }

    function view_return($id = NULL)
    {
        $this->erp->checkPermissions('return_sales');

        if ($this->input->get('id')) {
            $id = $this->input->get('id');
        }
        $this->data['error'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('error');
        $inv = $this->sales_model->getReturnByID($id);
		//$this->erp->print_arrays($inv);
        $this->erp->view_rights($inv->created_by);
        $this->data['barcode'] = "<img src='" . site_url('products/gen_barcode/' . $inv->reference_no) . "' alt='" . $inv->reference_no . "' class='pull-left' />";
        $this->data['customer'] = $this->site->getCompanyByID($inv->customer_id);
        $this->data['payments'] = $this->sales_model->getPaymentsForSale($id);
        $this->data['biller'] = $this->site->getCompanyByID($inv->biller_id);
        $this->data['user'] = $this->site->getUser($inv->created_by);
        $this->data['warehouse'] = $this->site->getWarehouseByID($inv->warehouse_id);
        $this->data['inv'] = $inv;
        $this->data['rows'] = $this->sales_model->getAllReturnItems($id);
        $this->data['sale'] = $this->sales_model->getInvoiceByID($inv->sale_id);
        $bc = array(array('link' => base_url(), 'page' => lang('home')), array('link' => site_url('sales'), 'page' => lang('sales')), array('link' => '#', 'page' => lang('view_return')));
        $meta = array('page_title' => lang('view_return_details'), 'bc' => $bc);
        $this->page_construct('sales/view_return', $meta, $this->data);
    }

    function pdf($id = NULL, $view = NULL, $save_bufffer = NULL)
    {
        $this->erp->checkPermissions();

        if ($this->input->get('id')) {
            $id = $this->input->get('id');
        }
        $this->data['error'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('error');
        $inv = $this->sales_model->getInvoiceByID($id);
        $this->erp->view_rights($inv->created_by);
        $this->data['barcode'] = "<img src='" . site_url('products/gen_barcode/' . $inv->reference_no) . "' alt='" . $inv->reference_no . "' class='pull-left' />";
        $this->data['customer'] = $this->site->getCompanyByID($inv->customer_id);
        $this->data['payments'] = $this->sales_model->getPaymentsForSale($id);
        $this->data['biller'] = $this->site->getCompanyByID($inv->biller_id);
        $this->data['user'] = $this->site->getUser($inv->created_by);
        $this->data['warehouse'] = $this->site->getWarehouseByID($inv->warehouse_id);
        $this->data['inv'] = $inv;
        $return = $this->sales_model->getReturnBySID($id);
        $this->data['return_sale'] = $return;
        $this->data['rows'] = $this->sales_model->getAllInvoiceItems($id);
        $this->data['return_items'] = $return ? $this->sales_model->getAllReturnItems($return->id) : NULL;
        //$this->data['paypal'] = $this->sales_model->getPaypalSettings();
        //$this->data['skrill'] = $this->sales_model->getSkrillSettings();

        $name = lang("sale") . "_" . str_replace('/', '_', $inv->reference_no) . ".pdf";
        $html = $this->load->view($this->theme . 'sales/pdf', $this->data, TRUE);
        if ($view) {
            $this->load->view($this->theme . 'sales/pdf', $this->data);
        } elseif ($save_bufffer) {
            return $this->erp->generate_pdf($html, $name, $save_bufffer, $this->data['biller']->invoice_footer);
        } else {
            $this->erp->generate_pdf($html, $name, FALSE, $this->data['biller']->invoice_footer);
        }
    }

    function email($id = NULL)
    {
        $this->erp->checkPermissions(false, true);

        if ($this->input->get('id')) {
            $id = $this->input->get('id');
        }
        $inv = $this->sales_model->getInvoiceByID($id);
        $this->form_validation->set_rules('to', lang("to") . " " . lang("email"), 'trim|required|valid_email');
        $this->form_validation->set_rules('subject', lang("subject"), 'trim|required');
        $this->form_validation->set_rules('cc', lang("cc"), 'trim');
        $this->form_validation->set_rules('bcc', lang("bcc"), 'trim');
        $this->form_validation->set_rules('note', lang("message"), 'trim');

        if ($this->form_validation->run() == true) {
            $this->erp->view_rights($inv->created_by);
            $to = $this->input->post('to');
            $subject = $this->input->post('subject');
            if ($this->input->post('cc')) {
                $cc = $this->input->post('cc');
            } else {
                $cc = NULL;
            }
            if ($this->input->post('bcc')) {
                $bcc = $this->input->post('bcc');
            } else {
                $bcc = NULL;
            }
            $customer = $this->site->getCompanyByID($inv->customer_id);
            $this->load->library('parser');
            $parse_data = array(
                'reference_number' => $inv->reference_no,
                'contact_person' => $customer->name,
                'company' => $customer->company,
                'site_link' => base_url(),
                'site_name' => $this->Settings->site_name,
                'logo' => '<img src="' . base_url() . 'assets/uploads/logos/' . $this->Settings->logo . '" alt="' . $this->Settings->site_name . '"/>'
            );
            $msg = $this->input->post('note');
            $message = $this->parser->parse_string($msg, $parse_data);

            $biller = $this->site->getCompanyByID($inv->biller_id);
            $paypal = $this->sales_model->getPaypalSettings();
            $skrill = $this->sales_model->getSkrillSettings();
            $btn_code = '<div id="payment_buttons" class="text-center margin010">';
            if ($paypal->active == "1" && $inv->grand_total != "0.00") {
                if (trim(strtolower($customer->country)) == $biller->country) {
                    $paypal_fee = $paypal->fixed_charges + ($inv->grand_total * $paypal->extra_charges_my / 100);
                } else {
                    $paypal_fee = $paypal->fixed_charges + ($inv->grand_total * $paypal->extra_charges_other / 100);
                }
                $btn_code .= '<a href="https://www.paypal.com/cgi-bin/webscr?cmd=_xclick&business=' . $paypal->account_email . '&item_name=' . $inv->reference_no . '&item_number=' . $inv->id . '&image_url=' . base_url() . 'assets/uploads/logos/' . $this->Settings->logo . '&amount=' . (($inv->grand_total - $inv->paid) + $paypal_fee) . '&no_shipping=1&no_note=1&currency_code=' . $this->default_currency->code . '&bn=FC-BuyNow&rm=2&return=' . site_url('sales/view/' . $inv->id) . '&cancel_return=' . site_url('sales/view/' . $inv->id) . '&notify_url=' . site_url('payments/paypalipn') . '&custom=' . $inv->reference_no . '__' . ($inv->grand_total - $inv->paid) . '__' . $paypal_fee . '"><img src="' . base_url('assets/images/btn-paypal.png') . '" alt="Pay by PayPal"></a> ';

            }
            if ($skrill->active == "1" && $inv->grand_total != "0.00") {
                if (trim(strtolower($customer->country)) == $biller->country) {
                    $skrill_fee = $skrill->fixed_charges + ($inv->grand_total * $skrill->extra_charges_my / 100);
                } else {
                    $skrill_fee = $skrill->fixed_charges + ($inv->grand_total * $skrill->extra_charges_other / 100);
                }
                $btn_code .= ' <a href="https://www.moneybookers.com/app/payment.pl?method=get&pay_to_email=' . $skrill->account_email . '&language=EN&merchant_fields=item_name,item_number&item_name=' . $inv->reference_no . '&item_number=' . $inv->id . '&logo_url=' . base_url() . 'assets/uploads/logos/' . $this->Settings->logo . '&amount=' . (($inv->grand_total - $inv->paid) + $skrill_fee) . '&return_url=' . site_url('sales/view/' . $inv->id) . '&cancel_url=' . site_url('sales/view/' . $inv->id) . '&detail1_description=' . $inv->reference_no . '&detail1_text=Payment for the sale invoice ' . $inv->reference_no . ': ' . $inv->grand_total . '(+ fee: ' . $skrill_fee . ') = ' . $this->erp->formatMoney($inv->grand_total + $skrill_fee) . '&currency=' . $this->default_currency->code . '&status_url=' . site_url('payments/skrillipn') . '"><img src="' . base_url('assets/images/btn-skrill.png') . '" alt="Pay by Skrill"></a>';
            }

            $btn_code .= '<div class="clearfix"></div>
    </div>';
            $message = $message . $btn_code;

            $attachment = $this->pdf($id, NULL, 'S');
        } elseif ($this->input->post('send_email')) {
            $this->data['error'] = (validation_errors() ? validation_errors() : $this->session->flashdata('error'));
            $this->session->set_flashdata('error', $this->data['error']);
            redirect($_SERVER["HTTP_REFERER"]);
        }

        if ($this->form_validation->run() == true && $this->erp->send_email($to, $subject, $message, NULL, NULL, $attachment, $cc, $bcc)) {
            delete_files($attachment);
            $this->session->set_flashdata('message', lang("email_sent"));
            redirect("sales");
        } else {

            if (file_exists('./themes/' . $this->theme . '/views/email_templates/sale.html')) {
                $sale_temp = file_get_contents('themes/' . $this->theme . '/views/email_templates/sale.html');
            } else {
                $sale_temp = file_get_contents('./themes/default/views/email_templates/sale.html');
            }

            $this->data['subject'] = array('name' => 'subject',
                'id' => 'subject',
                'type' => 'text',
                'value' => $this->form_validation->set_value('subject', lang('invoice').' (' . $inv->reference_no . ') '.lang('from').' ' . $this->Settings->site_name),
            );
            $this->data['note'] = array('name' => 'note',
                'id' => 'note',
                'type' => 'text',
                'value' => $this->form_validation->set_value('note', $sale_temp),
            );
            $this->data['customer'] = $this->site->getCompanyByID($inv->customer_id);

            $this->data['id'] = $id;
            $this->data['modal_js'] = $this->site->modal_js();
            $this->load->view($this->theme . 'sales/email', $this->data);
        }
    }

    /* ------------------------------------------------------------------ */
	/*=================================chin local updated=================================*/
    function add($sale_order_id = NULL, $delivery_id = NULL,$quote_ID = NULL)
    {
		
		$this->erp->checkPermissions('add', null, 'sales');
		$qid = '';
		if($sale_order_id){
			$sale_o = $this->sale_order_model->getSaleOrder($sale_order_id);
			$qid = $sale_o->quote_id;
			
			if(($this->sale_order_model->getSaleOrder($sale_order_id)->order_status) == 'pending'){
				$this->session->set_flashdata('error', lang("sale_order_n_approved"));
				redirect($_SERVER["HTTP_REFERER"]);
			}
			if(($this->sale_order_model->getSaleOrder($sale_order_id)->order_status) == 'rejected'){
				$this->session->set_flashdata('error', lang("sale_order_has_been_rejected"));
				redirect($_SERVER["HTTP_REFERER"]);
			}
			
			if(($this->sale_order_model->getSaleOrder($sale_order_id)->sale_status) != 'order'){
				$this->session->set_flashdata('error', lang("sale_order_has_been_created"));
				redirect($_SERVER["HTTP_REFERER"]);
			}
		}
		if($quote_ID){
			$sale_q = $this->quotes_model->getQuotesData($quote_ID);
			$qid = $sale_q->quote_id;
			 if (($this->quotes_model->getQuotesData($quote_ID)->status) == 'pending' ) {
				$this->session->set_flashdata('error', lang('quote_has_not_been_approved_s'));
				redirect($_SERVER['HTTP_REFERER']);
			} 
			 if ( ($this->quotes_model->getQuotesData($quote_ID)->status) == 'rejected') {
				$this->session->set_flashdata('error', lang('quote_has_been_rejected'));
				redirect($_SERVER['HTTP_REFERER']);
			} 
			if (($this->quotes_model->getQuotesData($quote_ID)->issue_invoice) != 'pending' ) {
				$this->session->set_flashdata('error', lang('quote_has_been_created'));
				redirect($_SERVER['HTTP_REFERER']);
			}
		}
        $this->form_validation->set_message('is_natural_no_zero', lang("no_zero_required"));
        $this->form_validation->set_rules('customer_1', lang("customer"), 'required');
        $this->form_validation->set_rules('biller', lang("biller"), 'required');
        $this->form_validation->set_rules('sale_status', lang("sale_status"), 'required');
        
        if ($this->form_validation->run() == true) {

            $quantity 	= "quantity";
            $product 	= "product";
            $unit_cost 	= "unit_cost";
            $tax_rate 	= "tax_rate";
			$biller_id 			= $this->input->post('biller');
            $reference 	= $this->input->post('reference_no') ? $this->input->post('reference_no') : $this->site->getReference('so',$biller_id);
            if ($this->Owner || $this->Admin) {
                $date = $this->erp->fld($this->input->post('date'));
            } else {
                $date = date('Y-m-d H:i:s');
            }

            $warehouse_id 		= $this->input->post('warehouse');
            $customer_id 		= $this->input->post('customer_1');
			$group_area 		= $this->input->post('area');
			$amout_paid 		= $this->input->post('amount-paid');
			$saleman_by 		= $this->input->post('saleman');
            $total_items 		= $this->input->post('total_items');
            $sale_status 		= $this->input->post('sale_status');
            $payment_status 	= 'due';
            $payment_term 		= $this->input->post('payment_term');
            $delivery_by   		= $this->input->post('delivery_by');
            $due_date 			= $payment_term ? date('Y-m-d', strtotime('+' . $payment_term . ' days')) : NULL;
            $shipping 			= $this->input->post('shipping') ? $this->input->post('shipping') : 0;
            $customer_details 	= $this->site->getCompanyByID($customer_id);
            $customer 			= $customer_details->company ? $customer_details->company : $customer_details->name;
            $biller_details 	= $this->site->getCompanyByID($biller_id);
            $biller 			= $biller_details->company != '-' ? $biller_details->company : $biller_details->name;
            $note 				= $this->erp->clear_tags($this->input->post('note'));
            $staff_note 		= $this->erp->clear_tags($this->input->post('staff_note'));
            $quote_id 			= $this->input->post('quote_id') ? $this->input->post('quote_id') : NULL;
			$paid_by 			= $this->input->post('paid_by');
			$delivery_update 	= $this->input->post('delivery_id_update');
			
            $total 				= 0;
            $product_tax 		= 0;
            $order_tax 			= 0;
            $product_discount 	= 0;
            $order_discount 	= 0;
            $percentage 		= '%';
			$g_total_txt1 		= 0;
            $loans 				= array();
            $i 					= isset($_POST['product_code']) ? sizeof($_POST['product_code']) : 0;
           
			for ($r = 0; $r < $i; $r++) {
                $item_id 		= $_POST['product_id'][$r];
                $item_type 		= $_POST['product_type'][$r];
                $item_code 		= $_POST['product_code'][$r];
				$item_note 		= $_POST['product_note'][$r];
                $item_name 		= $_POST['product_name'][$r];
                $item_option 	= isset($_POST['product_option'][$r]) && $_POST['product_option'][$r] != 'false' ? $_POST['product_option'][$r] : NULL;
				$item_quantity 	= $_POST['quantity'][$r];
				
				$real_item_quantity = $item_quantity;
				/* CHECKING...
				if($item_option != Null && $item_option != "" && $item_option != 0){
					$option_details = $this->sales_model->getProductOptionByID($item_option);
					$real_item_quantity = $item_quantity * $option_details->qty_unit;
				}else{
					$real_item_quantity = $item_quantity;
				}
				*/

                $real_unit_price = $this->erp->formatDecimal($_POST['real_unit_price'][$r]);
                $unit_price = $this->erp->formatDecimal($_POST['unit_price'][$r]);
				$net_price = $this->erp->formatDecimal($_POST['net_price'][$r]);
                
				
				$item_unit_quantity = $_POST['quantity'][$r];
                $item_serial 		= isset($_POST['serial'][$r]) ? $_POST['serial'][$r] : '';
                $item_tax_rate 		= isset($_POST['product_tax'][$r]) ? $_POST['product_tax'][$r] : NULL;
                $item_discount 		= isset($_POST['product_discount'][$r]) ? $_POST['product_discount'][$r] : NULL;
                
                //$g_total_txt = $_POST['grand_total'][$r];
				 

                if (isset($item_code) && isset($real_unit_price) && isset($unit_price) && isset($item_quantity)) {
                    $product_details = $item_type != 'manual' ? $this->sales_model->getProductByCode($item_code) : NULL;
                   // $unit_price = $real_unit_price;
                    $pr_discount = 0;

					if (isset($item_discount)) {
                        $discount = $item_discount;
                        $dpos = strpos($discount, $percentage);
                        if ($dpos !== false) {
                            $pds = explode("%", $discount);
                            $pr_discount = ((($this->erp->formatDecimal($unit_price)) * (Float) ($pds[0])) / 100);
                        } else {
                            $pr_discount = $this->erp->formatDecimal($discount/$item_quantity);
                        }
                    }
                    $unitPrice = $unit_price;
                    $unit_price = $this->erp->formatDecimal($unit_price - $pr_discount);
                    $item_net_price = $unit_price;
                    $pr_item_discount = $this->erp->formatDecimal($pr_discount * $item_quantity);
                    $product_discount += $pr_item_discount;
                    $pr_tax = 0; $pr_item_tax = 0; $item_tax = 0; $tax = "";

                    if (isset($item_tax_rate) && $item_tax_rate != 0) {
                        $pr_tax = $item_tax_rate;
                        $tax_details = $this->site->getTaxRateByID($pr_tax);
                        if ($tax_details->type == 1 && $tax_details->rate != 0) {
                            if ($product_details && $product_details->tax_method == 1) {
                                $item_tax = $this->erp->formatDecimal((($unit_price) * $tax_details->rate) / 100, 4);
                                $tax = $tax_details->rate . "%";
								$item_net_price = $unit_price;
                            } else {
                                $item_tax = ((($unit_price) * $tax_details->rate) / (100 + $tax_details->rate));
                                $tax = $tax_details->rate . "%";
                                $item_net_price = $unit_price - $item_tax;
                            }
                        } elseif ($tax_details->type == 2) {

                            if ($product_details && $product_details->tax_method == 1) {
                                $item_tax = ((($unit_price) * $tax_details->rate) / 100);
                                $tax = $tax_details->rate . "%";
								$item_net_price = $unit_price;
                            } else {
                                $item_tax =((($unit_price) * $tax_details->rate) / (100 + $tax_details->rate));
                                $tax = $tax_details->rate . "%";
                                $item_net_price = $unit_price - $item_tax;
                            }
                            $item_tax = $this->erp->formatDecimal($tax_details->rate);
                            $tax = $tax_details->rate;
                        }
                        $pr_item_tax = $this->erp->formatDecimal($item_tax * $item_unit_quantity, 4);
                    }

                    $product_tax += $pr_item_tax;
					
					if( $product_details->tax_method == 0){
						$subtotal = (($unit_price * $item_unit_quantity));
					}else{
						$subtotal = (($unit_price * $item_unit_quantity) + $pr_item_tax);
					}
				
                    $products[] = array(
                        'product_id' 		=> $item_id,
                        'product_code' 		=> $item_code,
                        'product_name' 		=> $item_name,
                        'product_type' 		=> $item_type,
                        'option_id' 		=> $item_option,
                        'net_unit_price' 	=> $item_net_price,
                        'unit_price' 		=> $this->erp->formatDecimal($unitPrice),
                        'quantity' 			=> $real_item_quantity,
                        'warehouse_id' 		=> $warehouse_id,
                        'item_tax' 			=> $pr_item_tax,
                        'tax_rate_id' 		=> $pr_tax,
                        'tax' 				=> $tax,
                        'discount' 			=> $item_discount,
                        'item_discount' 	=> $pr_item_discount,
                        'subtotal' 			=> $this->erp->formatDecimal($subtotal),
                        'serial_no' 		=> $item_serial,
                        'real_unit_price' 	=> $real_unit_price,
						'product_noted' 	=> $item_note
                    );
					
					//$total += $this->erp->formatDecimal(($item_net_price* $item_unit_quantity), 4);
					$total += $subtotal;
                }
            }
				
            if (empty($products)) {
                $this->form_validation->set_rules('product', lang("order_items"), 'required');
            } else {
                krsort($products);
            }

            if ($this->input->post('order_discount')) {
                $order_discount_id = $this->input->post('order_discount');
                $opos = strpos($order_discount_id, $percentage);
                if ($opos !== false) {
                    $ods = explode("%", $order_discount_id);
                    $order_discount = $this->erp->formatDecimal(((($total) * (Float) ($ods[0])) / 100), 4);
                } else {
                    $order_discount = $this->erp->formatDecimal(($total * $order_discount_id) / 100);
                }
            } else {
                $order_discount_id = null;
            }
            $total_discount = $this->erp->formatDecimal($order_discount + $product_discount);
            //echo $this->erp->floorFigure($product_discount);die();
            if ($this->Settings->tax2) {
                $order_tax_id = $this->input->post('order_tax');
                if ($order_tax_details = $this->site->getTaxRateByID($order_tax_id)) {
                    if ($order_tax_details->type == 2) {
                        $order_tax = $this->erp->formatDecimal($order_tax_details->rate);
                    } elseif ($order_tax_details->type == 1) {
                        $order_tax = $this->erp->formatDecimal(((($total + $shipping - $order_discount) * $order_tax_details->rate) / 100), 4);
                    }
                }
            } else {
                $order_tax_id = null;
            }
			
            $total_tax = $this->erp->formatDecimal(($product_tax + $order_tax), 4); 
            $grand_total = $this->erp->formatDecimal(($total + $order_tax + $this->erp->formatDecimal($shipping) - $order_discount), 4);
	
			$amount_limit = $this->sales_model->getAmountPaidByCustomer($customer_id);
			$credit = (int)($amount_limit->amount) + (int)($total);
			$setting_credit = $this->Settings->credit_limit;
			
			if($setting_credit == 1 && $credit > $amount_limit->credit_limited && $amount_limit->credit_limit > 0){				
				$this->session->set_flashdata('error', lang("credit_limit_required"));
				redirect($_SERVER["HTTP_REFERER"]);
			}
	
			$data = array(
				'date' => $date,
                'reference_no' 			=> $reference,
                'customer_id' 			=> $customer_id,
                'customer' 				=> $customer,
				'group_areas_id' 		=> $group_area,
                'biller_id' 			=> $biller_id,
                'biller' 				=> $biller,
                'warehouse_id' 			=> $warehouse_id,
                'note' 					=> $note,
                'staff_note' 			=> $staff_note,
                'total' 				=> $this->erp->formatDecimal($total),
                'product_discount' 		=> $this->erp->formatDecimal($product_discount),
                'order_discount_id' 	=> $order_discount_id,
                'order_discount' 		=> $order_discount,
                'total_discount' 		=> $total_discount,
                'product_tax' 			=> $this->erp->formatDecimal($product_tax),
                'order_tax_id' 			=> $order_tax_id,
                'order_tax' 			=> $order_tax,
                'total_tax' 			=> $total_tax,
                'shipping' 				=> $this->erp->formatDecimal($shipping),
                'grand_total' 			=> $grand_total,
                'total_items' 			=> $total_items,
                'sale_status' 			=> $sale_status,
                'payment_status' 		=> $payment_status,
                'payment_term' 			=> $payment_term,
                'due_date' 				=> $due_date,
                'paid' 					=> ($amout_paid != '' || $amout_paid != 0 || $amout_paid != null)? $amout_paid : 0,
                'created_by' 			=> $this->session->userdata('user_id'),
				'saleman_by' 			=> $saleman_by,
				'deposit_customer_id' 	=> $this->input->post('customer'),
				'delivery_by' 			=> $delivery_by,
				'bill_to' 				=> $this->input->post('bill_to'),
				'po' 					=> $this->input->post('po'),
				'type' 					=> $this->input->post('d_type'),
				'type_id' 				=> $this->input->post('type_id'),
				'so_id' 				=> ($sale_order_id? $sale_order_id:''),
				'quote_id' 				=> $qid
            );
			
            if ($payment_status == 'partial' || $payment_status == 'paid') {
				if ($this->input->post('payment_date')) {
                   $payment_date = $this->erp->fld($this->input->post('payment_date'));
				} else {
                  $payment_date = date('Y-m-d H:i:s');
				}

                if ($this->input->post('paid_by') == 'gift_card') {
                    $gc = $this->site->getGiftCardByNO($this->input->post('gift_card_no'));
                    $amount_paying = $grand_total >= $gc->balance ? $gc->balance : $grand_total;
                    $gc_balance = $gc->balance - $amount_paying;
					
					$payment = array(
						'date' 			=> $date,
						'reference_no' 	=> $this->input->post('payment_reference_no'),
						'amount' 		=> $this->erp->formatDecimal($amount_paying),
						'paid_by' 		=> $this->input->post('paid_by'),
						'cheque_no' 	=> $this->input->post('cheque_no'),
						'cc_no' 		=> $this->input->post('gift_card_no'),
						'cc_holder' 	=> $this->input->post('pcc_holder'),
						'cc_month' 		=> $this->input->post('pcc_month'),
						'cc_year' 		=> $this->input->post('pcc_year'),
						'cc_type' 		=> $this->input->post('pcc_type'),
						'created_by' 	=> $this->session->userdata('user_id'),
						'note' 			=> $this->input->post('payment_note'),
						'type' 			=> 'received',
						'gc_balance' 	=> $gc_balance,
						'biller_id' 	=> $biller_id,
						'add_payment' 	=> '0',
						'bank_account' 	=> $this->input->post('bank_account')
					);
                } else {
					$payment = array(
						'date' 			=> $date,
						'reference_no' 	=> $this->input->post('payment_reference_no'),
						'amount' 		=> ($amout_paid != '' || $amout_paid != 0 || $amout_paid != null)? $amout_paid : 0,
						'paid_by' 		=> $this->input->post('paid_by'),
						'cheque_no' 	=> $this->input->post('cheque_no'),
						'cc_no' 		=> $this->input->post('pcc_no'),
						'cc_holder' 	=> $this->input->post('pcc_holder'),
						'cc_month' 		=> $this->input->post('pcc_month'),
						'cc_year' 		=> $this->input->post('pcc_year'),
						'cc_type' 		=> $this->input->post('pcc_type'),
						'created_by' 	=> $this->session->userdata('user_id'),
						'note' 			=> $this->input->post('payment_note'),
						'type' 			=> 'received',
						'biller_id' 	=> $biller_id,
						'add_payment' 	=> '0',
						'bank_account' 	=> $this->input->post('bank_account')
					);
                }
				if($_POST['paid_by'] == 'depreciation') {
					$no = sizeof($_POST['no']);
					$period = 1;
					for($m = 0; $m < $no; $m++){
						$dateline = date('Y-m-d', strtotime($_POST['dateline'][$m]));
						$loans[] = array(
							'period' 	=> $period,
							'sale_id' 	=> '',
							'interest' 	=> $_POST['interest'][$m],
							'principle' => $_POST['principle'][$m],
							'payment' 	=> $_POST['payment_amt'][$m],
							'balance' 	=> $_POST['balance'][$m],
							'type' 		=> $_POST['depreciation_type'],
							'rated' 	=> $_POST['depreciation_rate1'],
							'note' 		=> $_POST['note_1'][$m],
							'dateline' 	=> $dateline,
							'biller_id' => $biller_id
						);
						$period++;
					}
				}else{
					$loans = array();
				}
				
            } else {
                $payment = array();
            }
            if ($_FILES['document']['size'] > 0) {
                $this->load->library('upload');
                $config['upload_path'] = $this->digital_upload_path;
                $config['allowed_types'] = $this->digital_file_types;
                $config['max_size'] = $this->allowed_file_size;
                $config['overwrite'] = FALSE;
                $config['encrypt_name'] = TRUE;
                $this->upload->initialize($config);
                if (!$this->upload->do_upload('document')) {
                    $error = $this->upload->display_errors();
                    $this->session->set_flashdata('error', $error);
                    redirect($_SERVER["HTTP_REFERER"]);
                }
                $photo = $this->upload->file_name;
                $data['attachment'] = $photo;
            }
			
			if ($_FILES['document1']['size'] > 0) {
                $this->load->library('upload');
                $config['upload_path'] = $this->digital_upload_path;
                $config['allowed_types'] = $this->digital_file_types;
                $config['max_size'] = $this->allowed_file_size;
                $config['overwrite'] = FALSE;
                $config['encrypt_name'] = TRUE;
                $this->upload->initialize($config);
                if (!$this->upload->do_upload('document1')) {
                    $error = $this->upload->display_errors();
                    $this->session->set_flashdata('error', $error);
                    redirect($_SERVER["HTTP_REFERER"]);
                }
                $photo = $this->upload->file_name;
                $data['attachment1'] = $photo;
            }
			
			if ($_FILES['document2']['size'] > 0) {
                $this->load->library('upload');
                $config['upload_path'] = $this->digital_upload_path;
                $config['allowed_types'] = $this->digital_file_types;
                $config['max_size'] = $this->allowed_file_size;
                $config['overwrite'] = FALSE;
                $config['encrypt_name'] = TRUE;
                $this->upload->initialize($config);
                if (!$this->upload->do_upload('document2')) {
                    $error = $this->upload->display_errors();
                    $this->session->set_flashdata('error', $error);
                    redirect($_SERVER["HTTP_REFERER"]);
                }
                $photo = $this->upload->file_name;
                $data['attachment2'] = $photo;
            }
			
			//$this->erp->print_arrays($data, $products);
        }
		
        if ($this->form_validation->run() == true) {
			
			$sale_id = $this->sales_model->addSale($data, $products, $payment, $loans, $delivery_update);
			if($sale_id > 0){
				//add deposit
				if($paid_by == "deposit"){
					$deposits = array(
						'date' 			=> $date,
						'reference' 	=> $reference,
						'company_id' 	=> $customer_id,
						'amount' 		=> (-1) * $amout_paid,
						'paid_by' 		=> $paid_by,
						'note' 			=> ($note? $note:$customer),
						'created_by' 	=> $this->session->userdata('user_id'),
						'biller_id' 	=> $biller_id,
						'sale_id' 		=> $sale_id,
						'bank_code' 	=> $this->input->post('bank_account'),
						'status' 		=> 'paid'
					);
					
					$this->sales_model->add_deposit($deposits);
				}
				// update sale_order_status 				
				//$this->sales_model->updateOrderStatus($data['type_id']);
			}
			
            $this->session->set_userdata('remove_s2', '1');
			
            if ($quote_ID) {
                $this->db->update('quotes', array('issue_invoice' => 'sale'), array('id' => $quote_ID));
            }
			if ($sale_order_id) {
                $this->db->update('sale_order', array('sale_status' => 'sale'), array('id' => $sale_order_id));
            }
            $this->session->set_flashdata('message', lang("sale_added"));
            $this->db->select_max('id');
            $s = $this->db->get_where('erp_sales', array('created_by' => $this->session->userdata('user_id')), 1);
            //$this->print_($s->row()->id);
			
			$sale = $this->sales_model->getInvoiceByID($sale_id);
			$address = $customer_details->address . " " . $customer_details->city . " " . $customer_details->state . " " . $customer_details->postal_code . " " . $customer_details->country . "<br>Tel: " . $customer_details->phone . " Email: " . $customer_details->email;
			$dlDetails = array(
				'date' => $date,
				'sale_id' => $sale_id,
				'do_reference_no' => $this->site->getReference('do'),
				'sale_reference_no' => $sale->reference_no,
				'customer' => $customer_details->name,
				'address' => $address,
				//'note' => ' ',
				'created_by' => $this->session->userdata('user_id'),
				'delivery_status' => 'pending',
                'delivery_by' => $delivery_by
			);
			
			$pos = $this->sales_model->getSetting();
			if($pos->auto_delivery == 1){
				$this->sales_model->addDelivery($dlDetails);
			}

			$invoice_view=$this->Settings->invoice_view;
			
			if($invoice_view==0){
				//redirect("sales/invoice_landscap_a5/".$s->row()->id);
				redirect("sales/print_/".$s->row()->id);
			}
			else if($invoice_view==1){
				redirect("sales/invoice/".$s->row()->id);
			}
			else if($invoice_view==2){
				redirect("sales/tax_invoice/".$s->row()->id);
			}
			else if($invoice_view==3){
				redirect("sales/print_/".$s->row()->id);
			}
			else if($invoice_view==4){
				redirect("sales/invoice_landscap_a5/".$s->row()->id);
			}
            //redirect("sales/print_/".$s->row()->id);
			
        } else {
			
            if ($sale_order_id){
				
                $sale_order = $this->sales_model->getSaleOrder($sale_order_id);
				$this->data['sale_order'] = $sale_order;
				$items = $this->sales_model->getSaleOrdItems($sale_order_id);
				$this->data['sale_order_id'] = $sale_order_id;
				$this->data['type'] = "sale_order";
				$this->data['type_id'] = $sale_order_id;
				
				$customer = $this->site->getCompanyByID($sale_order->customer_id);
				
                $c = rand(100000, 9999999);
                foreach ($items as $item) {
                    $row = $this->site->getProductByID($item->product_id);
					
                    if (!$row) {
                        $row = json_decode('{}');
                        $row->tax_method = 0;
                    } else {
                        unset($row->details, $row->product_details, $row->supplier1price, $row->supplier2price, $row->supplier3price, $row->supplier4price, $row->supplier5price);
                    }
                    $row->quantity = 0;
                    $pis = $this->sales_model->getPurchasedItems($item->product_id, $item->warehouse_id, $item->option_id);
                    if($pis){
                        foreach ($pis as $pi) {
                            $row->quantity += $pi->quantity_balance;
                        }
                    }
                    $row->id = $item->product_id;
                    $row->code = $item->product_code;
                    //$row->name = $item->product_name;
                    $row->type = $item->product_type;
                    $row->qty = $item->quantity;
                    $row->discount = $item->discount ? $item->discount : '0';
                    $row->price = $this->erp->formatDecimal($item->net_unit_price+$this->erp->formatDecimal($item->item_discount/$item->quantity));
                    $row->unit_price = $row->tax_method ? $item->unit_price+$this->erp->formatDecimal($item->item_discount/$item->quantity)+$this->erp->formatDecimal($item->item_tax/$item->quantity) : $item->unit_price+($item->item_discount/$item->quantity);
                    $row->real_unit_price = $item->real_unit_price;
                    $row->tax_rate = $item->tax_rate_id;
                    $row->serial = '';
                    $row->option = $item->option_id;
					
					$group_prices = $this->sales_model->getProductPriceGroup($item->product_id, $customer->price_group_id);
					$all_group_prices = $this->sales_model->getProductPriceGroup($item->product_id);
					$row->price_id = 0;
					
                    $options = $this->sales_model->getProductOptions($row->id, $item->warehouse_id);
                    if ($options) {
                        $option_quantity = 0;
                        foreach ($options as $option) {
                            $pis = $this->sales_model->getPurchasedItems($row->id, $item->warehouse_id, $item->option_id);
                            if($pis){
                                foreach ($pis as $pi) {
                                    $option_quantity += $pi->quantity_balance;
                                }
                            }
                            if($option->quantity > $option_quantity) {
                                $option->quantity = $option_quantity;
                            }
                        }
                    }
                    $combo_items = FALSE;
                    if ($row->type == 'combo') {
                        $combo_items = $this->sales_model->getProductComboItems($row->id, $item->warehouse_id);
                    }
                    $ri = $this->Settings->item_addition ? $row->id : $c;
                    if ($row->tax_rate) {
                        $tax_rate = $this->site->getTaxRateByID($row->tax_rate);
                        $pr[$ri] = array('id' => $c, 'item_id' => $row->id, 'label' => $row->name . " (" . $row->code . ")", 'row' => $row, 'combo_items' => $combo_items, 'tax_rate' => $tax_rate, 'options' => $options, 'makeup_cost' => 0,'group_prices'=>$group_prices, 'all_group_price' => $all_group_prices);
                    } else {
                        $pr[$ri] = array('id' => $c, 'item_id' => $row->id, 'label' => $row->name . " (" . $row->code . ")", 'row' => $row, 'combo_items' => $combo_items, 'tax_rate' => false, 'options' => $options, 'makeup_cost' => 0,'group_prices'=>$group_prices, 'all_group_price' => $all_group_prices);
                    }
                    $c++;
                }
				 $this->data['sale_order_id'] =$sale_order_id;
                $this->data['sale_order_items'] = json_encode($pr);
				$this->data['payment_deposit'] = $payment_deposit;
            }
			//$this->erp->print_arrays($row->code);
			if ($delivery_id){
				
                $sale_order = $this->sales_model->getDeliveryByID($delivery_id);
				$this->data['sale_order'] = $sale_order;
				$items = $this->sales_model->getDeliveryItemsByItemId($delivery_id);
				$this->data['delivery_id'] = $delivery_id;
				$this->data['type'] = "delivery";
				$this->data['type_id'] = $delivery_id;
				$customer = $this->site->getCompanyByID($sale_order->customer_id);
                $c = rand(100000, 9999999);
                foreach ($items as $item) {
                    $row = $this->site->getProductByID($item->product_id);
                    if (!$row) {
                        $row = json_decode('{}');
                        $row->tax_method = 0;
                    } else {
                        unset($row->details, $row->product_details, $row->supplier1price, $row->supplier2price, $row->supplier3price, $row->supplier4price, $row->supplier5price);
                    }
                    $row->quantity = 0;
                    $pis = $this->sales_model->getPurchasedItems($item->product_id, $item->warehouse_id, $item->option_id);
                    if($pis){
                        foreach ($pis as $pi) {
                            $row->quantity += $pi->quantity_balance;
                        }
                    }
                    $row->id = $item->product_id;
                    $row->code = $item->product_code;
                    $row->type = $item->product_type;
                    $row->qty = $item->dqty_received;
                    $row->discount = $item->discount ? $item->discount : '0';
                    $row->price = $this->erp->formatDecimal($item->net_unit_price+$this->erp->formatDecimal($item->item_discount/$item->quantity));
                    $row->unit_price = $row->tax_method ? $item->unit_price+$this->erp->formatDecimal($item->item_discount/$item->quantity)+$this->erp->formatDecimal($item->item_tax/$item->quantity) : $item->unit_price+($item->item_discount/$item->quantity);
                    $row->real_unit_price = $item->real_unit_price;
                    $row->tax_rate = $item->tax_rate_id;
                    $row->serial = '';
                    $row->option = $item->option_id;
					
					$group_prices = $this->sales_model->getProductPriceGroup($item->product_id, $customer->price_group_id);
					$all_group_prices = $this->sales_model->getProductPriceGroup($item->product_id);
					$row->price_id = 0;
					
                    $options = $this->sales_model->getProductOptions($row->id, $item->warehouse_id);
                    if ($options) {
                        $option_quantity = 0;
                        foreach ($options as $option) {
                            $pis = $this->sales_model->getPurchasedItems($row->id, $item->warehouse_id, $item->option_id);
                            if($pis){
                                foreach ($pis as $pi) {
                                    $option_quantity += $pi->quantity_balance;
                                }
                            }
                            if($option->quantity > $option_quantity) {
                                $option->quantity = $option_quantity;
                            }
                        }
                    }
                    $combo_items = FALSE;
                    if ($row->type == 'combo') {
                        $combo_items = $this->sales_model->getProductComboItems($row->id, $item->warehouse_id);
                    }
                    $ri = $this->Settings->item_addition ? $row->id : $c;
                    if ($row->tax_rate) {
                        $tax_rate = $this->site->getTaxRateByID($row->tax_rate);
                        $pr[$ri] = array('id' => $c, 'item_id' => $row->id, 'label' => $row->name . " (" . $row->code . ")", 'row' => $row, 'combo_items' => $combo_items, 'tax_rate' => $tax_rate, 'options' => $options, 'makeup_cost' => 0,'group_prices'=>$group_prices, 'all_group_price' => $all_group_prices);
                    } else {
                        $pr[$ri] = array('id' => $c, 'item_id' => $row->id, 'label' => $row->name . " (" . $row->code . ")", 'row' => $row, 'combo_items' => $combo_items, 'tax_rate' => false, 'options' => $options, 'makeup_cost' => 0,'group_prices'=>$group_prices, 'all_group_price' => $all_group_prices);
                    }
                    $c++;
                }
				
				//$this->erp->print_arrays($pr);
                $this->data['sale_order_items'] = json_encode($pr);
				 $this->data['delivery_id'] = $delivery_id;
            }
			
			if($quote_ID){
                $quote = $this->sales_model->getQuoteByID($quote_ID);
				$this->data['quotes'] = $quote;
				$items = $this->sales_model->getAllQuoteItems($quote_ID);
				$this->data['quote_ID'] = $quote_ID;
				$this->data['type'] = "quote";
				$this->data['type_id'] = $quote_ID;
				$customer = $this->site->getCompanyByID($quote->customer_id);
                $c = rand(100000, 9999999);
                foreach ($items as $item) {
                    $row = $this->site->getProductByID($item->product_id);
					
                    if (!$row) {
                        $row = json_decode('{}');
                        $row->tax_method = 0;
                    } else {
                        unset($row->details, $row->product_details, $row->supplier1price, $row->supplier2price, $row->supplier3price, $row->supplier4price, $row->supplier5price);
                    }
					
                    $row->quantity = 0;
                    $pis = $this->sales_model->getPurchasedItems($item->product_id, $item->warehouse_id, $item->option_id);
                    if($pis){
                        foreach ($pis as $pi) {
                            $row->quantity += $pi->quantity_balance;
                        }
                    }
                    $row->id = $item->product_id;
                    $row->code = $item->product_code;
                    $row->type = $item->product_type;
                    $row->qty = $item->quantity;
                    $row->discount = $item->discount ? $item->discount : '0';
                    $row->price = $this->erp->formatDecimal($item->net_unit_price+$this->erp->formatDecimal($item->item_discount/$item->quantity));
                    $row->unit_price = $row->tax_method ? $item->unit_price+$this->erp->formatDecimal($item->item_discount/$item->quantity)+$this->erp->formatDecimal($item->item_tax/$item->quantity) : $item->unit_price+($item->item_discount/$item->quantity);
                    $row->real_unit_price = $item->real_unit_price;
                    $row->tax_rate = $item->tax_rate_id;
                    $row->serial = '';
                    $row->option = $item->option_id;
					
					$group_prices = $this->sales_model->getProductPriceGroup($item->product_id, $customer->price_group_id);
					$all_group_prices = $this->sales_model->getProductPriceGroup($item->product_id);
					$row->price_id = 0;

                    $options = $this->sales_model->getProductOptions($row->id, $item->warehouse_id);
                    if ($options) {
                        $option_quantity = 0;
                        foreach ($options as $option) {
                            $pis = $this->sales_model->getPurchasedItems($row->id, $item->warehouse_id, $item->option_id);
                            if($pis){
                                foreach ($pis as $pi) {
                                    $option_quantity += $pi->quantity_balance;
                                }
                            }
                            if($option->quantity > $option_quantity) {
                                $option->quantity = $option_quantity;
                            }
                        }
                    }
                    $combo_items = FALSE;
                    if ($row->type == 'combo') {
                        $combo_items = $this->sales_model->getProductComboItems($row->id, $item->warehouse_id);
                    }
                    $ri = $this->Settings->item_addition ? $row->id : $c;
                    if ($row->tax_rate) {
                        $tax_rate = $this->site->getTaxRateByID($row->tax_rate);
                        $pr[$ri] = array('id' => $c, 'item_id' => $row->id, 'label' => $row->name . " (" . $row->code . ")", 'row' => $row, 'combo_items' => $combo_items, 'tax_rate' => $tax_rate, 'options' => $options, 'makeup_cost' => 0,'group_prices'=>$group_prices, 'all_group_price' => $all_group_prices);
                    } else {
                        $pr[$ri] = array('id' => $c, 'item_id' => $row->id, 'label' => $row->name . " (" . $row->code . ")", 'row' => $row, 'combo_items' => $combo_items, 'tax_rate' => false, 'options' => $options, 'makeup_cost' => 0,'group_prices'=>$group_prices, 'all_group_price' => $all_group_prices);
                    }
                    $c++;
                }
				//$this->erp->print_arrays($pr);
                $this->data['quote_id'] = $quote_ID;
				 $this->data['sale_order_items'] = json_encode($pr);
				$this->data['payment_deposit'] = $payment_deposit;
			}
			$this->load->model('purchases_model');
			$this->data['exchange_rate'] = $this->site->getCurrencyByCode('KHM');
            $this->data['error'] = (validation_errors() ? validation_errors() : $this->session->flashdata('error'));
            $this->data['billers'] = $this->site->getAllCompanies('biller');
            $this->data['warehouses'] = $this->site->getAllWarehouses();
            $this->data['tax_rates'] = $this->site->getAllTaxRates();
			$this->data['drivers'] = $this->site->getAllCompanies('driver');
			$this->data['agencies'] = $this->site->getAllUsers();
			$this->data['customers'] = $this->site->getCustomers();
			$this->data['currency'] = $this->site->getCurrency();
			$this->data['areas'] = $this->site->getArea();
			$this->data['payment_term'] = $this->site->getAllPaymentTerm();
			$this->data['bankAccounts'] =  $this->site->getAllBankAccounts();
            $this->data['slnumber'] = '';
			$this->data['categories'] = $this->site->getAllCategories();
			$this->data['unit'] = $this->purchases_model->getUnits();
			$this->data['reference'] = $this->site->getReference('so');
            $this->data['payment_ref'] = $this->site->getReference('sp');
			$this->data['setting'] = $this->site->get_setting();
            $bc = array(array('link' => base_url(), 'page' => lang('home')), array('link' => site_url('sales'), 'page' => lang('sales')), array('link' => '#', 'page' => lang('add_sale')));
            $meta = array('page_title' => lang('add_sale'), 'bc' => $bc);
            $this->page_construct('sales/add', $meta, $this->data);
        }
    }
	
	function getReferenceByProject($field,$biller_id){
		$reference_no = $this->site->getReference($field,$biller_id);
		echo json_encode($reference_no);
	}
	/*========================================end local updated=================================*/
	function getCustomersByArea($area = NULL)
    {
        if ($rows = $this->sales_model->getCustomersByArea($area)) {
            $data = json_encode($rows);
        } else {
            $data = false;
        }
        echo $data;
    }
	
	function save_edit_deliveries($id=null) {
		
		$date = $this->erp->fld($this->input->post('date'));
		$delivery_by = $this->input->post('delivery_by');
		$note = $this->input->post('note');
		$getdelivery = $this->sales_model->getDelivery($id);
		$updated_count = $getdelivery->updated_count + 1;
		$delivery_reference = $this->input->post('delivery_reference');
		$delivery_status = $this->input->post('delivery_status');
		$get_delivery = $this->sales_model->getDeliveriesByID($id);

		$deliveryrec = array(
			'date' => $date,
			'do_reference_no' => $delivery_reference,
			'delivery_by' => $delivery_by,
			'updated_by' => $this->session->userdata('user_id'),
			'updated_count' => $updated_count,
			'type' => $get_delivery->type,
			'note' => $note,
			'delivery_status' => $delivery_status
		);
		
		$productID = $this->input->post('product_id');
		$item_id = $this->input->post('item_id');
		$productName = $this->input->post('product_name');
		$warehouse_id = $this->input->post('warehouse_id');
		$qty_received = $this->input->post('quantity_received');
		$ditem_id = $this->input->post('ditem_id');
		$option_id = $this->input->post('product_option');
		$balance = $this->input->post('h_balance');
		$b_balance = $this->input->post('b_balance');
		$total_qty_rec = $this->input->post('totalQtyRec');
		
		$rows = sizeof($productID);
		for($i=0; $i<$rows; $i++) {
			$b_quantity = $b_balance[$i];
			$ending_balance = $b_balance[$i] - $qty_received[$i];
			$getproduct = $this->site->getProductByID($productID[$i]);
			
			$delivery_items[] =  array(
									'item_id' => $item_id[$i],
									'product_id' => $productID[$i],
									'sale_id' => $getdelivery->sale_id,
									'product_name' => $productName[$i],
									'product_type' => $getproduct->type,
									'option_id' => $option_id[$i],
									'warehouse_id' => $warehouse_id[$i],
									'begining_balance' => $b_quantity,
									'quantity_received' => $qty_received[$i],
									'ending_balance' => $ending_balance,
									'updated_by' => $this->session->userdata('user_id'),
									'updated_count' => $updated_count,
			);
		}
		
		if($this->sales_model->save_edit_delivery($id, $deliveryrec, $delivery_items)){
			
			if($id > 0){
				$invoice_status = false;
				$sale_order_status = false;
				if($getdelivery->type == "invoice") {
					for($i=0; $i<$rows; $i++) {
						$lastQtyReceived = $total_qty_rec[$i] + $qty_received[$i];
						$qty_receive = array('quantity_received' => $lastQtyReceived);
						$condition = array('id' => $item_id[$i],'product_id' => $productID[$i],'sale_id'=>$getdelivery->sale_id);
						if($this->sales_model->updateSaleItemQtyReceived($qty_receive,$condition)){
							$invoice_status = true;
						}
					}
				}
				
				if($getdelivery->type=="sale_order") {
					for($i=0; $i<$rows; $i++) {
						$lastQtyReceived = $total_qty_rec[$i] + $qty_received[$i];
						$qty_receive = array('quantity_received' => $lastQtyReceived);
						$condition = array('id' => $item_id[$i],'product_id' => $productID[$i],'sale_order_id'=>$getdelivery->sale_id);
						if($this->sales_model->updateSaleOrderQtyReceived($qty_receive,$condition)){
							$sale_order_status = true;
						}
					}
				}
				
				if($invoice_status == true) {
				// update delivery status
					$getAllQty = $this->sales_model->getAllSaleItemQty($getdelivery->sale_id);
					$updateStatus = false;
					foreach($getAllQty as $qty){
						
						if($qty->qty - $qty->qty_received > 0){
							$status = array('delivery_status' => 'partial');
						}else if($qty->qty - $qty->qty_received == 0){
							$status = array('delivery_status' => 'completed');
						}else {
							$status = array('delivery_status' => 'due');	
						}
						$condition = array('id'=>$getdelivery->sale_id);
						$this->db->where($condition);
						$this->db->update('sales', $status);
						$updateStatus = true;

					}
					
					if($updateStatus == true) {
						// update stock here....
						foreach($delivery_items as $delivery_item){
							
							$delivery_quantity = $delivery_item['quantity_received'];
							$getproduct = $this->site->getProductByID($delivery_item['product_id']);
							$getsaleitem = $this->sales_model->getSaleItemByID($delivery_item['item_id']);
							
							$stock_info[] = array(
								'product_id' => $delivery_item['product_id'],
								'product_code' => $getproduct->code,
								'product_name' => $delivery_item['product_name'],
								'product_type' => $getproduct->type,
								'option_id' => $delivery_item['option_id'],
								'net_unit_price' => $getsaleitem->net_unit_price,
								'unit_price' => $getsaleitem->unit_price,
								'quantity' => $delivery_quantity,
								'warehouse_id' => $delivery_item['warehouse_id'],
								'item_tax' => $getsaleitem->item_tax,
								'tax_rate_id' => $getsaleitem->tax_rate_id,
								'tax' => $getsaleitem->tax,
								'discount' => $getsaleitem->discount,
								'item_discount' => $getsaleitem->item_discount,
								'subtotal' => $getsaleitem->subtotal,
								'serial_no' => $getsaleitem->serial_no,
								'real_unit_price' => $getsaleitem->real_unit_price,
								'product_noted' => $getsaleitem->product_noted
							);
							
						}
						
						if(sizeof($stock_info) >0){
							if($delivery_status == "completed") {
								$cost = $this->site->costing($stock_info);
								$this->site->syncPurchaseItems($cost);
							}
							$this->site->syncQuantity(NULL, NULL, NULL, NULL, NULL, NULL, $stock_info);
						}
						
					}
					
				}
				
				if($sale_order_status == true){
				// update delivery status
					$getAllQty = $this->sales_model->getAllSaleOrderItemQty($getdelivery->sale_id);
					$updateStatus = false;
					foreach($getAllQty as $qty){
						if($qty->qty - $qty->qty_received > 0){
							$status = array('delivery_status' => 'partial', 'sale_status' => 'delivery');
						}else if($qty->qty - $qty->qty_received == 0){
							$status = array('delivery_status' => 'completed', 'sale_status' => 'delivery');	
						}else {
							$status = array('delivery_status' => 'due', 'sale_status' => 'order');	
						}
						$condition = array('id'=>$getdelivery->sale_id);
						$this->db->where($condition);
						$this->db->update('sale_order', $status);
						$updateStatus = true;

					}
					
					if($updateStatus == true) {
						// update stock here....
						foreach($delivery_items as $delivery_item){
							
							$delivery_quantity = $delivery_item['quantity_received'];
							$getproduct = $this->site->getProductByID($delivery_item['product_id']);
							$getsaleitem = $this->sales_model->getSaleOrderItemByID($delivery_item['item_id']);
							
							$stock_info[] = array(
								'product_id' => $delivery_item['product_id'],
								'product_code' => $getproduct->code,
								'product_name' => $delivery_item['product_name'],
								'product_type' => $getproduct->type,
								'option_id' => $delivery_item['option_id'],
								'net_unit_price' => $getsaleitem->net_unit_price,
								'unit_price' => $getsaleitem->unit_price,
								'quantity' => $delivery_quantity,
								'warehouse_id' => $delivery_item['warehouse_id'],
								'item_tax' => $getsaleitem->item_tax,
								'tax_rate_id' => $getsaleitem->tax_rate_id,
								'tax' => $getsaleitem->tax,
								'discount' => $getsaleitem->discount,
								'item_discount' => $getsaleitem->item_discount,
								'subtotal' => $getsaleitem->subtotal,
								'serial_no' => $getsaleitem->serial_no,
								'real_unit_price' => $getsaleitem->real_unit_price,
								'product_noted' => $getsaleitem->product_noted
							);
							
						}
						
						if(sizeof($stock_info) > 0){
							if($delivery_status == "completed") {
								$cost = $this->site->costing($stock_info);
								$this->site->syncPurchaseItems($cost);
							}
							$this->site->syncQuantity(NULL, NULL, NULL, NULL, NULL, NULL, $stock_info);	
						}
						
					}
					
				}
			
			}
			$this->session->set_flashdata('message', lang("update successfully"));
			redirect('sales/deliveries');
			
		}else{
			$this->session->set_flashdata('error', lang("no_delivery_selected"));
			redirect($_SERVER["HTTP_REFERER"]);
		}


	}
	/*======================================chin local updated=======================================*/
	function edit_deliveries($delivery_id = NULL)
    {
		$this->erp->checkPermissions('deliveries');
		$this->form_validation->set_rules('cust', lang("customer"), 'required');
		$this->form_validation->set_rules('delivery_reference', lang("delivery_reference"), 'required');

        if ($this->form_validation->run() == true) {

        } else {
			$this->data['error'] = (validation_errors() ? validation_errors() : $this->session->flashdata('error'));
			
			$deliv = $this->sales_model->getDelivery($delivery_id);
			$deliv_items = $this->sales_model->getDeliveryItemsByID($delivery_id, $deliv->type);
			$this->data['drivers'] = $this->site->getDrivers();
			if($deliv->type == 'sale_order') {
				$this->data['saleInfo'] = $this->sales_model->getSaleOrderInfo($deliv->sale_id);
			}else {
				$this->data['saleInfo'] = $this->sales_model->getSaleInfo($deliv->sale_id);
			}
			$this->data['delivery'] = $deliv;
			$this->data['delivery_items'] = $deliv_items;
			
			foreach($deliv_items as $deliv_item) {
				$ditem =  $deliv_item->id;
				$productId = $deliv_item->product_id;
				$productName = $deliv_item->product_name;
				$productCode = $deliv_item->code;
				$quantity_received = $deliv_item->quantity_received;
				$quantity = $deliv_item->ord_qty;
				$balance = $deliv_item->ord_qty - $deliv_item->ord_qty_rec;
				$option_id = $deliv_item->option_id;
				$arr[] = array(
					'ditem' => $ditem,
					'item_id' => $deliv_item->item_id,
					'pid' => $productId,
					'pname' => $productName,
					'warehouse_id' => $deliv_item->warehouse_id,
					'pcode' => $productCode,
					'qty' => $quantity,
					'qty_received' => $quantity_received,
					'balance' => $balance,
					'option_id' => $option_id
				);
			}

			$this->data['quantity_recs'] = $arr;
		
			//$this->erp->print_arrays($arr);
			$this->data['setting'] = $this->site->get_setting();
			$this->data['modal_js'] = $this->site->modal_js();
            $bc = array(array('link' => base_url(), 'page' => lang('home')), array('link' => site_url('sales'), 'page' => lang('sales')), array('link' => '#', 'page' => lang('edit_deliveries')));
            $meta = array('page_title' => lang('edite_deliveries'), 'bc' => $bc);
            $this->page_construct('sales/edit_deliveries', $meta, $this->data);
        }


    }
	/*============================================end local updated=====================================*/

	function print_($id = NULL, $view = NULL, $save_bufffer = NULL)
    {
        $this->erp->checkPermissions('add', true, 'sales');

        if ($this->input->get('id')) {
            $id = $this->input->get('id');
        }
		$this->load->model('pos_model');
		$this->data['setting'] = $this->site->get_setting();
		$this->data['pos'] = $this->pos_model->getSetting();
        $this->data['error'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('error');
        $inv = $this->sales_model->getInvoiceByID($id);
        //$this->erp->view_rights($inv->created_by);
        $this->data['barcode'] = "<img src='" . site_url('products/gen_barcode/' . $inv->reference_no) . "' alt='" . $inv->reference_no . "' class='pull-left' />";
        $this->data['customer'] = $this->site->getCompanyByID($inv->customer_id);
        $this->data['payments'] = $this->sales_model->getPaymentsForSale($id);
        $this->data['biller'] = $this->site->getCompanyByID($inv->biller_id);
        $this->data['user'] = $this->site->getUser($inv->created_by);
        $this->data['warehouse'] = $this->site->getWarehouseByID($inv->warehouse_id);
        $this->data['inv'] = $inv;
		$this->data['payment_term'] = $this->sales_model->getPaymentermID($inv->payment_term);
		
		$return = $this->sales_model->getReturnBySID($id);
        $this->data['return_sale'] = $return;
        $records = $this->sales_model->getAllInvoiceItems($id);
		
		foreach($records as $record){
			$product_option = $record->option_id;
			if($product_option != Null && $product_option != "" && $product_option != 0){
				$item_quantity = $record->quantity;
				$record->quantity = 0;
				$option_details = $this->sales_model->getProductOptionByID($product_option);
				$record->quantity = $item_quantity / ($option_details->qty_unit);
			}
		}
		$this->data['rows'] = $records;
		$this->data['sale_order'] = $this->sales_model->getSaleOrderById($inv->type_id);
        $this->data['return_items'] = $return ? $this->sales_model->getAllReturnItems($return->id) : NULL;
        $this->data['title'] = "2";
		$this->data['sid'] = $id;
        $this->load->view($this->theme.'sales/print',$this->data);
    }
	
    function print_rks($id = NULL, $view = NULL, $save_bufffer = NULL)
    {
       $this->erp->checkPermissions('add', true, 'sales');

        if ($this->input->get('id')) {
            $id = $this->input->get('id');
        }
        $this->load->model('pos_model');
        $this->data['setting'] = $this->site->get_setting();
        $this->data['pos'] = $this->pos_model->getSetting();
        $this->data['error'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('error');
        $inv = $this->sales_model->getInvoiceByID($id);
        //$this->erp->view_rights($inv->created_by);
        $this->data['barcode'] = "<img src='" . site_url('products/gen_barcode/' . $inv->reference_no) . "' alt='" . $inv->reference_no . "' class='pull-left' />";
        $this->data['customer'] = $this->site->getCompanyByID($inv->customer_id);
        $this->data['payments'] = $this->sales_model->getPaymentsForSale($id);
        $this->data['biller'] = $this->site->getCompanyByID($inv->biller_id);
        $this->data['user'] = $this->site->getUser($inv->created_by);
        $this->data['warehouse'] = $this->site->getWarehouseByID($inv->warehouse_id);
        $this->data['inv'] = $inv;
        $this->data['payment_term'] = $this->sales_model->getPaymentermID($inv->payment_term);
        
        $return = $this->sales_model->getReturnBySID($id);
        $this->data['return_sale'] = $return;
        $records = $this->sales_model->getAllInvoiceItems($id);
        
        foreach($records as $record){
            $product_option = $record->option_id;
            if($product_option != Null && $product_option != "" && $product_option != 0){
                $item_quantity = $record->quantity;
                $record->quantity = 0;
                $option_details = $this->sales_model->getProductOptionByID($product_option);
                $record->quantity = $item_quantity / ($option_details->qty_unit);
            }
        }
        $this->data['rows'] = $records;
        $this->data['return_items'] = $return ? $this->sales_model->getAllReturnItems($return->id) : NULL;
        $this->data['title'] = "2";
        $this->data['sid'] = $id;
        $this->load->view($this->theme.'sales/print_rks',$this->data);
    }
	function print_1($id = NULL, $view = NULL, $save_bufffer = NULL)
    {
        $this->erp->checkPermissions('add', true, 'sales');

        if ($this->input->get('id')) {
            $id = $this->input->get('id');
        }
		$this->load->model('pos_model');
		$settings = $this->site->get_setting();
		$default_project_id=$settings->default_biller;
		
		$this->data['project_code'] = $this->site->getCompanyByID($default_project_id);
		
		$this->data['setting'] = $this->site->get_setting();
		$this->data['pos'] = $this->pos_model->getSetting();
        $this->data['error'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('error');
        $inv = $this->sales_model->getInvoiceByID($id);
        $this->erp->view_rights($inv->created_by);
        $this->data['barcode'] = "<img src='" . site_url('products/gen_barcode/' . $inv->reference_no) . "' alt='" . $inv->reference_no . "' class='pull-left' />";
        $this->data['customer'] = $this->site->getCompanyByID($inv->customer_id);
        $this->data['payments'] = $this->sales_model->getPaymentsForSale($id);
        $this->data['biller'] = $this->site->getCompanyByID($inv->biller_id);
        $this->data['user'] = $this->site->getUser($inv->created_by);
        $this->data['warehouse'] = $this->site->getWarehouseByID($inv->warehouse_id);
        $this->data['inv'] = $inv;
        $return = $this->sales_model->getReturnBySID($id);
        $this->data['return_sale'] = $return;
        $this->data['rows'] = $this->sales_model->getAllInvoiceItems($id);
        $this->data['return_items'] = $return ? $this->sales_model->getAllReturnItems($return->id) : NULL;
        $this->data['title'] = "2";
		$this->data['sid'] = $id;
        $this->load->view($this->theme.'sales/print1',$this->data);
    }
	function print_jewwel($id = NULL, $view = NULL, $save_bufffer = NULL)
    {
        $this->erp->checkPermissions('add', true, 'sales');

        if ($this->input->get('id')) {
            $id = $this->input->get('id');
        }
		$this->load->model('pos_model');
		$this->data['pos'] = $this->pos_model->getSetting();
        $this->data['error'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('error');
        $inv = $this->sales_model->getInvoiceByID($id);
        $this->erp->view_rights($inv->created_by);
        $this->data['barcode'] = "<img src='" . site_url('products/gen_barcode/' . $inv->reference_no) . "' alt='" . $inv->reference_no . "' class='pull-left' />";
        $this->data['customer'] = $this->site->getCompanyByID($inv->customer_id);
        $this->data['payments'] = $this->sales_model->getPaymentsForSale($id);
        $this->data['biller'] = $this->site->getCompanyByID($inv->biller_id);
        $this->data['user'] = $this->site->getUser($inv->created_by);
        $this->data['warehouse'] = $this->site->getWarehouseByID($inv->warehouse_id);
        $this->data['inv'] = $inv;
        $return = $this->sales_model->getReturnBySID($id);
        $this->data['return_sale'] = $return;
        $this->data['rows'] = $this->sales_model->getAllInvoiceItems($id);
        $this->data['return_items'] = $return ? $this->sales_model->getAllReturnItems($return->id) : NULL;
        $this->data['title'] = "2";
		$this->data['sid'] = $id;
        $this->load->view($this->theme.'sales/print_jewwel',$this->data);
    }
	
	function print_hch($id = NULL, $view = NULL, $save_bufffer = NULL)
    {
        $this->erp->checkPermissions('add', true, 'sales');

        if ($this->input->get('id')) {
            $id = $this->input->get('id');
        }
		$this->load->model('pos_model');
		$this->data['pos'] = $this->pos_model->getSetting();
        $this->data['error'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('error');
        $inv = $this->sales_model->getInvoiceByID($id);
        $this->erp->view_rights($inv->created_by);
        $this->data['barcode'] = "<img src='" . site_url('products/gen_barcode/' . $inv->reference_no) . "' alt='" . $inv->reference_no . "' class='pull-left' />";
        $this->data['customer'] = $this->site->getCompanyByID($inv->customer_id);
        $this->data['payments'] = $this->sales_model->getPaymentsForSale($id);
        $this->data['biller'] = $this->site->getCompanyByID($inv->biller_id);
        $this->data['user'] = $this->site->getUser($inv->created_by);
        $this->data['warehouse'] = $this->site->getWarehouseByID($inv->warehouse_id);
        $this->data['inv'] = $inv;
        $return = $this->sales_model->getReturnBySID($id);
        $this->data['return_sale'] = $return;
        $this->data['rows'] = $this->sales_model->getAllInvoiceItems($id);
        $this->data['return_items'] = $return ? $this->sales_model->getAllReturnItems($return->id) : NULL;
		$this->data['sid'] = $id;
        $this->load->view($this->theme.'sales/print_hch',$this->data);
    }
	
	/* ------------------------------ Sochin -------------------------------------------------------------------------------------------- */
	function cabon_print($sale_id = NULL, $modal = NULL)
    {
        $this->erp->checkPermissions('index');
        if ($this->input->get('id')) {
            $sale_id = $this->input->get('id');
        }
        $this->load->helper('text');
        $this->data['error'] = (validation_errors() ? validation_errors() : $this->session->flashdata('error'));
        $this->data['message'] = $this->session->flashdata('message');
        $this->data['rows'] = $this->pos_model->getAllInvoiceItems($sale_id);
        $inv = $this->sales_model->getInvoiceByID($sale_id);
        $biller_id = $inv->biller_id;
        $customer_id = $inv->customer_id;
        $this->data['biller'] = $this->pos_model->getCompanyByID($biller_id);
        $this->data['customer'] = $this->pos_model->getCompanyByID($customer_id);
        $this->data['payments'] = $this->sales_model->getPaymentsForSale($sale_id);
        $this->data['pos'] = $this->pos_model->getSetting();
        $this->data['barcode'] = $this->barcode($inv->reference_no, 'code39', 30);
        $this->data['inv'] = $inv;
        $this->data['sid'] = $sale_id;
		$this->data['exchange_rate'] = $this->pos_model->getExchange_rate();
		$this->data['exchange_rate_th'] = $this->pos_model->getExchange_rate('THA');
		$this->data['exchange_rate_kh_c'] = $this->pos_model->getExchange_rate('KHM');
        $this->data['modal'] = $modal;
        $this->data['page_title'] = $this->lang->line("invoice");
        $this->load->view($this->theme . 'sales/cabon_print', $this->data);
    }

    function barcode($text = NULL, $bcs = 'code39', $height = 50)
    {
        return site_url('products/gen_barcode/' . $text . '/' . $bcs . '/' . $height);
    }

	/* ------------------------------End----------------------------------------------------------------------------------------------- */

    /* -------------------------------------------------------------------------------------------------------------------------------- */
	/*======================================chin local updated===================================*/
    function edit($id = NULL)
    {
        $this->erp->checkPermissions('edit',null,'sales');
        if ($this->input->get('id')) {
            $id = $this->input->get('id');
        }

        $this->form_validation->set_message('is_natural_no_zero', lang("no_zero_required"));
        $this->form_validation->set_rules('reference_no', lang("reference_no"), 'required');
        $this->form_validation->set_rules('customer', lang("customer"), 'required');
        $this->form_validation->set_rules('biller', lang("biller"), 'required');
        $this->form_validation->set_rules('sale_status', lang("sale_status"), 'required');
        //$this->form_validation->set_rules('payment_status', lang("payment_status"), 'required');
        //$this->form_validation->set_rules('note', lang("note"), 'xss_clean');

        if ($this->form_validation->run() == true) {
            $quantity = "quantity";
            $product = "product";
            $unit_cost = "unit_cost";
            $tax_rate = "tax_rate";
            $reference = $this->input->post('reference_no');
            if ($this->Owner || $this->Admin) {
                $date = $this->erp->fld(trim($this->input->post('date')));
            } else {
                $date = date('Y-m-d H:i:s');
            }
            $warehouse_id = $this->input->post('warehouse');
            $customer_id = $this->input->post('customer');
            $biller_id = $this->input->post('biller');
            $group_area = $this->input->post('area');
			$saleman_by = $this->input->post('saleman');
            $total_items = $this->input->post('total_items');
            $sale_status = $this->input->post('sale_status');
            //$payment_status = $this->input->post('payment_status');
            $payment_status = 'due';
            $payment_term = $this->input->post('payment_term');
			$delivery_by = $this->input->post('delivery_by');
			$delivery_id = $this->input->post('delivery_id');
            $due_date = $payment_term ? date('Y-m-d', strtotime('+' . $payment_term . ' days')) : NULL;
            $shipping = $this->input->post('shipping') ? $this->input->post('shipping') : 0;
            $customer_details = $this->site->getCompanyByID($customer_id);
            $customer = $customer_details->company ? $customer_details->company : $customer_details->name;
            $biller_details = $this->site->getCompanyByID($biller_id);
            $biller = $biller_details->company != '-' ? $biller_details->company : $biller_details->name;
            $note = $this->erp->clear_tags($this->input->post('note'));
            $staff_note = $this->erp->clear_tags($this->input->post('staff_note'));
			$paid_by = $this->input->post('paid_by');
			
			$amout_paid = $this->input->post('amount-paid');

            $total = 0;
            $product_tax = 0;
            $order_tax = 0;
            $product_discount = 0;
            $order_discount = 0;
            $percentage = '%';
            $i = isset($_POST['product_code']) ? sizeof($_POST['product_code']) : 0;
            for ($r = 0; $r < $i; $r++) {
                $item_id = $_POST['product_id'][$r];
                $item_type = $_POST['product_type'][$r];
                $item_code = $_POST['product_code'][$r];
                $item_name = $_POST['product_name'][$r];
                $item_option = isset($_POST['product_option'][$r]) && $_POST['product_option'][$r] != 'false' ? $_POST['product_option'][$r] : NULL;
                //$option_details = $this->sales_model->getProductOptionByID($item_option);
                $real_unit_price = $this->erp->formatDecimal($_POST['real_unit_price'][$r]);
                $unit_price = $this->erp->formatDecimal($_POST['unit_price'][$r]);
				$net_price = $this->erp->formatDecimal($_POST['net_price'][$r]);
                $item_quantity = $_POST['quantity'][$r];
				$item_unit_quantity = $_POST['quantity'][$r];
                $item_serial = isset($_POST['serial'][$r]) ? $_POST['serial'][$r] : '';
                $item_tax_rate = isset($_POST['product_tax'][$r]) ? $_POST['product_tax'][$r] : NULL;
                $item_discount = isset($_POST['product_discount'][$r]) ? $_POST['product_discount'][$r] : NULL;

                if (isset($item_code) && isset($real_unit_price) && isset($unit_price) && isset($item_quantity)) {
                    $product_details = $item_type != 'manual' ? $this->sales_model->getProductByCode($item_code) : NULL;
                    // $unit_price = $real_unit_price;
                    $pr_discount = 0;

                    if (isset($item_discount)) {
                        $discount = $item_discount;
                        $dpos = strpos($discount, $percentage);
                        if ($dpos !== false) {
                            $pds = explode("%", $discount);
                            $pr_discount = $this->erp->formatDecimal(((($this->erp->formatDecimal($unit_price)) * (Float) ($pds[0])) / 100), 4);
                        } else {
                            $pr_discount = $this->erp->formatDecimal($discount/$item_quantity);
                        }
                    }
					$unitPrice = $unit_price;
                    $unit_price = $this->erp->formatDecimal($unit_price - $pr_discount);
					$item_net_price = $unit_price;
                    $pr_item_discount = $this->erp->formatDecimal($pr_discount * $item_quantity);
                    $product_discount += $pr_item_discount;
                    $pr_tax = 0; $pr_item_tax = 0; $item_tax = 0; $tax = "";

                    if (isset($item_tax_rate) && $item_tax_rate != 0) {
                        $pr_tax = $item_tax_rate;
                        $tax_details = $this->site->getTaxRateByID($pr_tax);
                        if ($tax_details->type == 1 && $tax_details->rate != 0) {

                            if ($product_details && $product_details->tax_method == 1) {
                                $item_tax = ((($unit_price) * $tax_details->rate) / 100);
                                $tax = $tax_details->rate . "%";
								$item_net_price = $unit_price;
                            } else {
                                $item_tax = ((($unit_price) * $tax_details->rate) / (100 + $tax_details->rate));
                                $tax = $tax_details->rate . "%";
                                $item_net_price = $unit_price - $item_tax;
                            }

                        } elseif ($tax_details->type == 2) {

                            if ($product_details && $product_details->tax_method == 1) {
                                $item_tax = ((($unit_price) * $tax_details->rate) / 100);
                                $tax = $tax_details->rate . "%";
								$item_net_price = $unit_price;
                            } else {
                                $item_tax = ((($unit_price) * $tax_details->rate) / (100 + $tax_details->rate));
                                $tax = $tax_details->rate . "%";
                                $item_net_price = $unit_price - $item_tax;
                            }

                            $item_tax = $this->erp->formatDecimal($tax_details->rate);
                            $tax = $tax_details->rate;

                        }
                        $pr_item_tax = $this->erp->formatDecimal($item_tax * $item_unit_quantity, 4);

                    }
                    $product_tax += $pr_item_tax;
					
					
					if( $product_details->tax_method == 0){
						$subtotal = ((($unit_price * $item_unit_quantity)));
					}else{
						$subtotal = ((($unit_price * $item_unit_quantity) + $pr_item_tax));
					}
					
                    $products[] = array(
                        'product_id' => $item_id,
                        'product_code' => $item_code,
                        'product_name' => $item_name,
                        'product_type' => $item_type,
                        'option_id' => $item_option,
                        'net_unit_price' => $item_net_price,
                        'unit_price' => $this->erp->formatDecimal($unitPrice),
                        'quantity' => $item_quantity,
                        'warehouse_id' => $warehouse_id,
                        'item_tax' => $pr_item_tax,
                        'tax_rate_id' => $pr_tax,
                        'tax' => $tax,
                        'discount' => $item_discount,
                        'item_discount' => $pr_item_discount,
                        'subtotal' => $this->erp->formatDecimal($subtotal),
                        'serial_no' => $item_serial,
                        'real_unit_price' => $real_unit_price
                    );
                    $total += $this->erp->formatDecimal($subtotal, 4);
                }
            }
            if (empty($products)) {
                $this->form_validation->set_rules('product', lang("order_items"), 'required');
            } else {
                krsort($products);
            }
            if ($this->input->post('order_discount')) {
                $order_discount_id = $this->input->post('order_discount');
                $opos = strpos($order_discount_id, $percentage);
                if ($opos !== false) {
                    $ods = explode("%", $order_discount_id);
                    $order_discount = $this->erp->formatDecimal(((($total) * (Float) ($ods[0])) / 100), 4);
                } else {
                    $order_discount = $this->erp->formatDecimal(($total * $order_discount_id) / 100);
                }
            } else {
                $order_discount_id = null;
            }
            $total_discount = $this->erp->formatDecimal($order_discount + $product_discount);

            if ($this->Settings->tax2) {
                $order_tax_id = $this->input->post('order_tax');
                if ($order_tax_details = $this->site->getTaxRateByID($order_tax_id)) {
                    if ($order_tax_details->type == 2) {
                        $order_tax = $this->erp->formatDecimal($order_tax_details->rate);
                    } elseif ($order_tax_details->type == 1) {
                        $order_tax = $this->erp->formatDecimal(((($total + $shipping - $order_discount) * $order_tax_details->rate) / 100), 4);
                    }
                }
            } else {
                $order_tax_id = null;
            }

            $total_tax = $this->erp->formatDecimal(($product_tax + $order_tax), 4); 
            $grand_total = $this->erp->formatDecimal(($total + $order_tax + $this->erp->formatDecimal($shipping) - $order_discount), 4);
            $sales = $this->sales_model->getInvoiceByID($id);
			$updated_count = $sales->updated_count + 1;
			$data = array('date' => $date,
                'reference_no' => $reference,
                'customer_id' => $customer_id,
                'customer' => $customer,
				'group_areas_id' => $group_area,
                'biller_id' => $biller_id,
                'biller' => $biller,
                'warehouse_id' => $warehouse_id,
                'note' => $note,
                'staff_note' => $staff_note,
                'total' => $this->erp->formatDecimal($total),
                'product_discount' => $this->erp->formatDecimal($product_discount),
                'order_discount_id' => $order_discount_id,
                'order_discount' => $order_discount,
                'total_discount' => $total_discount,
                'product_tax' => $this->erp->formatDecimal($product_tax),
                'order_tax_id' => $order_tax_id,
                'order_tax' => $order_tax,
                'total_tax' => $total_tax,
                'shipping' => $this->erp->formatDecimal($shipping),
                'grand_total' => $grand_total,
                'total_items' => $total_items,
                'sale_status' => $sale_status,
                //'payment_status' => $payment_status,
                'payment_term' => $payment_term,
				//'paid' => ($amout_paid != '' || $amout_paid != 0 || $amout_paid != null)? $amout_paid : 0,
                'due_date' => $due_date,
                'updated_by' => $this->session->userdata('user_id'),
                'updated_at' => date('Y-m-d H:i:s'),
				'updated_count' => $updated_count,
				'saleman_by' => $saleman_by,
				'deposit_customer_id' => $this->input->post('customer'),
				'bill_to' => $this->input->post('bill_to'),
				'po' => $this->input->post('po'),
				'so_id' => $this->input->post('sale_order_id'),
            );
			
			//$this->erp->print_arrays($data, $products);
            if ($_FILES['document']['size'] > 0) {
                $this->load->library('upload');
                $config['upload_path'] = $this->digital_upload_path;
                $config['allowed_types'] = $this->digital_file_types;
                $config['max_size'] = $this->allowed_file_size;
                $config['overwrite'] = FALSE;
                $config['encrypt_name'] = TRUE;
                $this->upload->initialize($config);
                if (!$this->upload->do_upload('document')) {
                    $error = $this->upload->display_errors();
                    $this->session->set_flashdata('error', $error);
                    redirect($_SERVER["HTTP_REFERER"]);
                }
                $photo = $this->upload->file_name;
                $data['attachment'] = $photo;
            }
			
			if ($_FILES['document1']['size'] > 0) {
                $this->load->library('upload');
                $config['upload_path'] = $this->digital_upload_path;
                $config['allowed_types'] = $this->digital_file_types;
                $config['max_size'] = $this->allowed_file_size;
                $config['overwrite'] = FALSE;
                $config['encrypt_name'] = TRUE;
                $this->upload->initialize($config);
                if (!$this->upload->do_upload('document1')) {
                    $error = $this->upload->display_errors();
                    $this->session->set_flashdata('error', $error);
                    redirect($_SERVER["HTTP_REFERER"]);
                }
                $photo = $this->upload->file_name;
                $data['attachment1'] = $photo;
            }
			
			if ($_FILES['document2']['size'] > 0) {
                $this->load->library('upload');
                $config['upload_path'] = $this->digital_upload_path;
                $config['allowed_types'] = $this->digital_file_types;
                $config['max_size'] = $this->allowed_file_size;
                $config['overwrite'] = FALSE;
                $config['encrypt_name'] = TRUE;
                $this->upload->initialize($config);
                if (!$this->upload->do_upload('document2')) {
                    $error = $this->upload->display_errors();
                    $this->session->set_flashdata('error', $error);
                    redirect($_SERVER["HTTP_REFERER"]);
                }
                $photo = $this->upload->file_name;
                $data['attachment2'] = $photo;
            }
			
			$sale = $this->sales_model->getInvoiceByID($sale_id);
			$address = $customer_details->address . " " . $customer_details->city . " " . $customer_details->state . " " . $customer_details->postal_code . " " . $customer_details->country . "<br>Tel: " . $customer_details->phone . " Email: " . $customer_details->email;
			$dlDetails = array(
				'date' => $date,
				'sale_id' => $id,
				'sale_reference_no' => $reference,
				'customer' => $customer_details->name,
				'address' => $address,
				//'note' => ' ',
				'created_by' => $this->session->userdata('user_id'),
				'delivery_status' => 'pending',
                'delivery_by' => $delivery_by
			);
			//$this->erp->print_arrays($dlDetails);
			$pos = $this->sales_model->getSetting();
			if($pos->auto_delivery == 1){
				$this->sales_model->updateDelivery($delivery_id, $dlDetails);
			}
			
			
			if ($payment_status == 'partial' || $payment_status == 'paid') {
                if ($this->input->post('paid_by') == 'gift_card') {
                    $gc = $this->site->getGiftCardByNO($this->input->post('gift_card_no'));
                    $amount_paying = $grand_total >= $gc->balance ? $gc->balance : $grand_total;
                    $gc_balance = $gc->balance - $amount_paying;
					
					$payment = array(
						'id' => $this->input->post('payment_id'),
						'date' => $date,
						'reference_no' => (($this->input->post('paid_by') == 'deposit')? $reference:$this->input->post('payment_reference_no')),
						'amount' => $this->erp->formatDecimal($amount_paying),
						'paid_by' => $this->input->post('paid_by'),
						'cheque_no' => $this->input->post('cheque_no'),
						'cc_no' => $this->input->post('gift_card_no'),
						'cc_holder' => $this->input->post('pcc_holder'),
						'cc_month' => $this->input->post('pcc_month'),
						'cc_year' => $this->input->post('pcc_year'),
						'cc_type' => $this->input->post('pcc_type'),
						'created_by' => $this->session->userdata('user_id'),
						'note' => $this->input->post('payment_note'),
						'type' => 'received',
						'gc_balance' => $gc_balance,
						'biller_id' => $biller_id,
						'add_payment' => '0',
						'bank_account' => $this->input->post('bank_account')
					); 
                } else {
					$payment = array(
						'id' => $this->input->post('payment_id'),
						'date' => $date,
						'reference_no' => (($this->input->post('paid_by') == 'deposit')? $reference:$this->input->post('payment_reference_no')),
						'amount' => $this->erp->formatDecimal($this->input->post('amount-paid')),
						'paid_by' => $this->input->post('paid_by'),
						'cheque_no' => $this->input->post('cheque_no'),
						'cc_no' => $this->input->post('pcc_no'),
						'cc_holder' => $this->input->post('pcc_holder'),
						'cc_month' => $this->input->post('pcc_month'),
						'cc_year' => $this->input->post('pcc_year'),
						'cc_type' => $this->input->post('pcc_type'),
						'created_by' => $this->session->userdata('user_id'),
						'note' => $this->input->post('payment_note'),
						'type' => 'received',
						'biller_id' => $biller_id,
						'add_payment' => '0',
						'bank_account' => $this->input->post('bank_account')
					);
                }
				if($_POST['paid_by'] == 'depreciation'){
					$no = sizeof($_POST['no']);
					$period = 1;
					for($m = 0; $m < $no; $m++){
						$dateline = date('Y-m-d', strtotime($_POST['dateline'][$m]));
						$loans[] = array(
							'period' => $period,
							'sale_id' => '',
							'interest' => $_POST['interest'][$m],
							'principle' => $_POST['principle'][$m],
							'payment' => $_POST['payment_amt'][$m],
							'balance' => $_POST['balance'][$m],
							'type' => $_POST['depreciation_type'],
							'rated' => $_POST['depreciation_rate1'],
							'note' => $_POST['note_1'][$m],
							'dateline' => $dateline
						);
						$period++;
					}
					//$this->erp->print_arrays($loans);
				}else{
					$loans = array();
				}
				
            } else {
                $payment = array();
            }
			

            //$this->erp->print_arrays($data, $products, $payment);
        }

        if ($this->form_validation->run() == true && $this->sales_model->updateSale($id, $data, $products, $payment, $loans)) {
			$this->session->set_userdata('remove_s2', '1');
			$deposit = $this->sales_model->getInvoiceDepositBySaleID($id);
			if($deposit){
				//update deposit
				if($paid_by == "deposit"){
					$deposits = array(
						'date' => $date,
						'reference' => $reference,
						'company_id' => $customer_id,
						'amount' => (-1) * $amout_paid,
						'paid_by' => $paid_by,
						'note' => ($note? $note:$customer),
						'created_by' => $this->session->userdata('user_id'),
						'biller_id' => $biller_id,
						'sale_id' => $id,
						'bank_code' => $this->input->post('bank_account'),
						'status' => 'paid'
					);
					$this->sales_model->updateDeposit($deposit->id, $deposits);
				}				
			}
			
            $this->session->set_userdata('remove_slls', 1);
            $this->session->set_flashdata('message', lang("sale_updated"));
            redirect("sales");
        } else {

            $this->data['error'] = (validation_errors() ? validation_errors() : $this->session->flashdata('error'));
			$sale = $this->sales_model->getInvoiceByID($id);
			$sale_order = '';
			if($sale->so_id > 0) {
				$sale_order = $this->sales_model->getSaleOrder($sale->so_id);
			}
			$this->data['sale_order'] = $sale_order;
            $this->data['inv'] = $sale;
			
            if ($this->data['inv']->date <= date('Y-m-d', strtotime('-3 months'))) {
                $this->session->set_flashdata('error', lang("sale_x_edited_older_than_3_months"));
                redirect($_SERVER["HTTP_REFERER"]);
            }

            $inv_items = $this->sales_model->getAllInvoiceItems($id);
			$customer = $this->site->getCompanyByID($sale->customer_id);
            $c = rand(100000, 9999999);
            foreach ($inv_items as $item) {
                $row = $this->sales_model->getProductByID($item->product_id, $item->warehouse_id);
                if (!$row) {
                    $row = json_decode('{}');
                    $row->tax_method = 0;
                    $row->quantity = 0;
                } else {
                    unset($row->details, $row->product_details, $row->cost, $row->supplier1price, $row->supplier2price, $row->supplier3price, $row->supplier4price, $row->supplier5price);
                }
                $pis = $this->sales_model->getPurchasedItems($item->product_id, $item->warehouse_id, $item->option_id);
				
				$group_prices = $this->sales_model->getProductPriceGroup($item->product_id, $customer->price_group_id);
				$all_group_prices = $this->sales_model->getProductPriceGroup($item->product_id);
				
				$row->price_id = 0;
				
                if($pis){
                    foreach ($pis as $pi) {
                        //$row->quantity += $pi->quantity_balance;
                    }
                }
				$test2 = $this->sales_model->getWP2($row->id, $item->warehouse_id);
				
				
                $row->id = $item->product_id;
                $row->code = $item->product_code;
                $row->name = $item->product_name;
                $row->type = $item->product_type;
                $row->qty = $item->quantity;
                $row->quantity = $row->wh_qty;
				$row->cost += $item->cost;
                $row->discount = $item->discount ? $item->discount : '0';
                $row->price = $this->erp->formatDecimal($item->net_unit_price+$this->erp->formatDecimal($item->item_discount/$item->quantity));
                $row->unit_price = $row->tax_method ? $item->unit_price+$this->erp->formatDecimal($item->item_discount/$item->quantity)+$this->erp->formatDecimal($item->item_tax/$item->quantity) : $item->unit_price+($item->item_discount/$item->quantity);
                $row->real_unit_price = $item->real_unit_price;
                $row->tax_rate = $item->tax_rate_id;
                $row->serial = $item->serial_no;
                $row->option = $item->option_id;
				$row->unit = $row->unit;
                $options = $this->sales_model->getProductOptions($row->id, $item->warehouse_id);
				$row->start_date = $item->start_date;
				$row->end_date = $item->end_date;
				
				$group_prices = $this->sales_model->getProductPriceGroup($row->id, $customer->price_group_id);
				$all_group_prices = $this->sales_model->getProductPriceGroup($row->id);
				$row->quantity = $test2->quantity;
				$row->price_id = 0;
				
                if ($options) {
                    $option_quantity = 0;
                    foreach ($options as $option) {
                        $pis = $this->sales_model->getPurchasedItems($row->id, $item->warehouse_id, $item->option_id);
                        if($pis){
                            foreach ($pis as $pi) {
                                $option_quantity += $pi->quantity_balance;
                            }
                        }
                        $option_quantity += $item->quantity;
                        if($option->quantity > $option_quantity) {
                            //$option->quantity = $option_quantity;
                        }
						$option->quantity = $test2->quantity;
                    }
                }
				
                $combo_items = FALSE;
                if ($row->type == 'combo') {
                    $combo_items = $this->sales_model->getProductComboItems($row->id, $item->warehouse_id);
                    $te = $combo_items;
                    foreach ($combo_items as $combo_item) {
                        $combo_item->quantity =  $combo_item->qty*$item->quantity;
                    }
                }
                $ri = $this->Settings->item_addition ? $row->id : $c;
                if ($row->tax_rate) {
                    $tax_rate = $this->site->getTaxRateByID($row->tax_rate);
                    $pr[$ri] = array('id' => $c, 'item_id' => $row->id, 'label' => $row->name . " (" . $row->code . ")", 'row' => $row, 'combo_items' => $combo_items, 'tax_rate' => $tax_rate, 'options' => $options, 'makeup_cost' => 0, 'group_prices' => $group_prices, 'all_group_prices' => $all_group_prices);
                } else {
                    $pr[$ri] = array('id' => $c, 'item_id' => $row->id, 'label' => $row->name . " (" . $row->code . ")", 'row' => $row, 'combo_items' => $combo_items, 'tax_rate' => false, 'options' => $options, 'makeup_cost' => 0, 'group_prices' => $group_prices, 'all_group_prices' => $all_group_prices);
                }
                $c++;
            }
			$this->load->model('purchases_model');
			//$this->erp->print_arrays($pr);
            $this->data['inv_items'] = json_encode($pr);
            $this->data['id'] = $id;
			$this->data['credit_limited']=$customer_details;
            //$this->data['currencies'] = $this->site->getAllCurrencies();
            $this->data['billers'] = ($this->Owner || $this->Admin) ? $this->site->getAllCompanies('biller') : NULL;
            $this->data['tax_rates'] = $this->site->getAllTaxRates();
			$this->data['agencies'] = $this->site->getAllUsers();
            $this->data['warehouses'] = $this->site->getAllWarehouses();
			$this->data['payment'] = $this->site->getInvoicePaymentBySaleID($id);
			$this->data['delivery'] = $this->sales_model->getDeliveryBySaleID($sale->id);
			$this->data['setting'] = $this->site->get_setting();
			$this->data['areas'] = $this->site->getArea();
			$this->data['categories'] = $this->site->getAllCategories();
			$this->data['unit'] = $this->purchases_model->getUnits();
			$this->data['payment_term'] = $this->site->getAllPaymentTerm();
			$this->data['bankAccounts'] =  $this->site->getAllBankAccounts();
			$this->data['payment_reference'] = $this->site->getReference('sp');
			$this->data['exchange_rate'] = $this->site->getCurrencyByCode('KHM');
			$this->session->set_userdata('remove_s2', '1');
            $bc = array(array('link' => base_url(), 'page' => lang('home')), array('link' => site_url('sales'), 'page' => lang('sales')), array('link' => '#', 'page' => lang('edit_sale')));
            $meta = array('page_title' => lang('edit_sale'), 'bc' => $bc);
            $this->page_construct('sales/edit', $meta, $this->data);
        }
    }
	/*=========================================end local updated===================================*/
    /* ------------------------------- */

    function return_sale($id = NULL)
    {
        $this->erp->checkPermissions('return_sales');

        if ($this->input->get('id')) {
            $id = $this->input->get('id');
        }

        // $this->form_validation->set_rules('reference_no', lang("reference_no"), 'required');
        $this->form_validation->set_rules('cust_id', lang("cust_id"), 'required');

        if ($this->form_validation->run() == true) {
            $sale = $this->sales_model->getInvoiceByID($id);
            $quantity = "quantity";
            $product = "product";
            $unit_cost = "unit_cost";
            $tax_rate = "tax_rate";
           $reference = $this->input->post('reference_no') ? $this->input->post('reference_no') : $this->site->getReference('re',$sale->biller_id);
            if ($this->Owner || $this->Admin) {
                $date = $this->erp->fld(trim($this->input->post('date')));
            } else {
                $date = date('Y-m-d H:i:s');
            }

            $return_surcharge = $this->input->post('return_surcharge') ? $this->input->post('return_surcharge') : 0;
            $note = $this->erp->clear_tags($this->input->post('note'));
			$shipping = $this->input->post('shipping');

            $total = 0;
            $product_tax = 0;
            $order_tax = 0;
            $product_discount = 0;
            $order_discount = 0;
            $percentage = '%';
            $i = isset($_POST['product_code']) ? sizeof($_POST['product_code']) : 0;
            for ($r = 0; $r < $i; $r++) {
                $item_id = $_POST['product_id'][$r];
                $item_type = $_POST['product_type'][$r];
                $item_code = $_POST['product_code'][$r];
				$item_cost = $_POST['product_cost'][$r];
                $item_name = $_POST['product_name'][$r];
                $sale_item_id = $_POST['sale_item_id'][$r];
                $item_option = isset($_POST['product_option'][$r]) && $_POST['product_option'][$r] != 'false' ? $_POST['product_option'][$r] : NULL;
                //$option_details = $this->sales_model->getProductOptionByID($item_option);
                $real_unit_price = $this->erp->formatDecimal($_POST['real_unit_price'][$r]);
                $unit_price = $this->erp->formatDecimal($_POST['unit_price'][$r]);
                $item_quantity = $_POST['quantity'][$r];
                $item_serial = isset($_POST['serial'][$r]) ? $_POST['serial'][$r] : '';
                $item_tax_rate = isset($_POST['product_tax'][$r]) ? $_POST['product_tax'][$r] : NULL;
                $item_discount = isset($_POST['product_discount'][$r]) ? $_POST['product_discount'][$r] : NULL;

                if (isset($item_code) && isset($real_unit_price) && isset($unit_price) && isset($item_quantity)) {
                    $product_details = $item_type != 'manual' ? $this->sales_model->getProductByCode($item_code) : NULL;

					if (isset($item_discount)) {
                        $discount = $item_discount;
                        $dpos = strpos($discount, $percentage);
                        if ($dpos !== false) {
                            $pds = explode("%", $discount);
                            $pr_discount = $this->erp->formatDecimal(((($this->erp->formatDecimal($unit_price * $item_quantity)) * (Float) ($pds[0])) / 100), 4);
                        } else {
                            $pr_discount = $this->erp->formatDecimal($discount);
                        }
                    }
					
                    $unit_price = $this->erp->formatDecimal($unit_price, 4);
                    $item_net_price = $unit_price;
                    $pr_item_discount = $this->erp->formatDecimal($pr_discount);
                    $product_discount += $pr_item_discount;
                    $pr_tax = 0; $pr_item_tax = 0; $item_tax = 0; $tax = "";

                    if (isset($item_tax_rate) && $item_tax_rate != 0) {
                        $pr_tax = $item_tax_rate;
                        $tax_details = $this->site->getTaxRateByID($pr_tax);
                        if ($tax_details->type == 1 && $tax_details->rate != 0) {
                            if ($product_details && $product_details->tax_method == 1) {
                                $item_tax = $this->erp->formatDecimal((($unit_price) * $tax_details->rate) / 100, 4);
                                $tax = $tax_details->rate . "%";
                            } else {
                                $item_tax = $this->erp->formatDecimal((($unit_price) * $tax_details->rate) / (100 + $tax_details->rate), 4);
                                $tax = $tax_details->rate . "%";
                                $item_net_price = $unit_price - $item_tax;
                            }
                        } elseif ($tax_details->type == 2) {

                            if ($product_details && $product_details->tax_method == 1) {
                                $item_tax = $this->erp->formatDecimal((($unit_price) * $tax_details->rate) / 100, 4);
                                $tax = $tax_details->rate . "%";
                            } else {
                                $item_tax = $this->erp->formatDecimal((($unit_price) * $tax_details->rate) / (100 + $tax_details->rate), 4);
                                $tax = $tax_details->rate . "%";
                                $item_net_price = $unit_price - $item_tax;
                            }
                            $item_tax = $this->erp->formatDecimal($tax_details->rate);
                            $tax = $tax_details->rate;
                        }
                        $pr_item_tax = $this->erp->formatDecimal($item_tax * $item_quantity, 4);
                    }

                    $product_tax += $pr_item_tax;
                    $subtotal = ((($item_net_price * $item_quantity) - $pr_item_discount) + $pr_item_tax);

                    $products[] = array(
                        'product_id' => $item_id,
                        'product_code' => $item_code,
                        'product_name' => $item_name,
                        'product_type' => $item_type,
                        'option_id' => $item_option,
                        'net_unit_price' => $item_net_price,
                        'unit_price' => $this->erp->formatDecimal($unit_price),
						'unit_cost' => $item_cost,
                        'quantity' => $item_quantity,
                        'warehouse_id' => $sale->warehouse_id,
                        'item_tax' => $pr_item_tax,
                        'tax_rate_id' => $pr_tax,
                        'tax' => $tax,
                        'discount' => $item_discount,
                        'item_discount' => $pr_item_discount,
                        'subtotal' => $this->erp->formatDecimal($subtotal)?$this->erp->formatDecimal($subtotal):0,
                        'serial_no' => $item_serial,
                        'real_unit_price' => $real_unit_price,
                        'sale_item_id' => $sale_item_id
                    );

                    $total += $subtotal;
                }
            }
            if (empty($products)) {
                $this->form_validation->set_rules('product', lang("order_items"), 'required');
            } else {
                krsort($products);
            }
			
			$paid_amount = $this->input->post('amount-paid');

            if ($this->input->post('discount')) {
                $order_discount_id = $this->input->post('order_discount');
                $opos = strpos($order_discount_id, $percentage);
                if ($opos !== false) {
                    $ods = explode("%", $order_discount_id);
                    //$order_discount = $this->erp->formatDecimal((($paid_amount + $product_tax) * (Float)($ods[0])) / 100);
					$order_discount = $this->erp->formatDecimal(((($total + $product_tax) * (Float) ($ods[0])) / 100), 4);
                } else {
                    $order_discount = $this->erp->formatDecimal(($total * $order_discount_id) / 100);
                }
            } else {
                $order_discount_id = NULL;
            }
            $total_discount = $order_discount + $product_discount;

            if ($this->Settings->tax2) {
                $order_tax_id = $this->input->post('order_tax');
                if ($order_tax_details = $this->site->getTaxRateByID($order_tax_id)) {
                    if ($order_tax_details->type == 2) {
                        $order_tax = $this->erp->formatDecimal($order_tax_details->rate);
                    } elseif ($order_tax_details->type == 1) {
                        $order_tax = $this->erp->formatDecimal(((($total + $shipping - $order_discount) * $order_tax_details->rate) / 100), 4);
                    }
                }
            } else {
                $order_tax_id = null;
            }

            $total_tax = $this->erp->formatDecimal($product_tax + $order_tax);
            //$grand_total = $this->erp->formatDecimal($paid_amount);
			$grand_total = $this->erp->formatDecimal(($total + $order_tax + $this->erp->formatDecimal($shipping) - $order_discount), 4);
            $data = array('date' => $date,
                'sale_id' => $id,
                'reference_no' => $reference,
                'customer_id' => $sale->customer_id,
                'customer' => $sale->customer,
                'biller_id' => $sale->biller_id,
                'biller' => $sale->biller,
                'warehouse_id' => $sale->warehouse_id,
                'note' => $note,
                'total' => $this->erp->formatDecimal($total),
                'product_discount' => $this->erp->formatDecimal($product_discount),
                'order_discount_id' => $order_discount_id,
                'order_discount' => $order_discount,
                'total_discount' => $total_discount,
                'product_tax' => $this->erp->formatDecimal($product_tax),
                'order_tax_id' => $order_tax_id,
                'order_tax' => $order_tax,
                'total_tax' => $total_tax,
				'shipping' => $shipping,
                'surcharge' => $this->erp->formatDecimal($return_surcharge),
                'grand_total' => $grand_total,
				'paid' => $this->erp->formatDecimal($this->input->post('amount-paid')),
                'created_by' => $this->session->userdata('user_id')
            );
			//$this->erp->print_arrays($data, $products);
            if ($this->input->post('amount-paid') && $this->input->post('amount-paid') > 0) {
                $payment = array(
                    'date' => $date,
                    'reference_no' => $this->input->post('payment_reference_no'),
                    'amount' => $this->erp->formatDecimal($this->input->post('amount-paid')),
                    'paid_by' => $this->input->post('paid_by'),
                    'cheque_no' => $this->input->post('cheque_no'),
                    'cc_no' => $this->input->post('pcc_no'),
                    'cc_holder' => $this->input->post('pcc_holder'),
                    'cc_month' => $this->input->post('pcc_month'),
                    'cc_year' => $this->input->post('pcc_year'),
                    'cc_type' => $this->input->post('pcc_type'),
                    'created_by' => $this->session->userdata('user_id'),
                    'type' => 'returned',
                    'biller_id' => $sale->biller_id ? $sale->biller_id : $this->default_biller_id,
					'add_payment' => '1',
					'bank_account' => $this->input->post('bank_account')
                );
            } else {
                $payment = array();
            }

            if ($_FILES['document']['size'] > 0) {
                $this->load->library('upload');
                $config['upload_path'] = $this->digital_upload_path;
                $config['allowed_types'] = $this->digital_file_types;
                $config['max_size'] = $this->allowed_file_size;
                $config['overwrite'] = FALSE;
                $config['encrypt_name'] = TRUE;
                $this->upload->initialize($config);
                if (!$this->upload->do_upload('document')) {
                    $error = $this->upload->display_errors();
                    $this->session->set_flashdata('error', $error);
                    redirect($_SERVER["HTTP_REFERER"]);
                }
                $photo = $this->upload->file_name;
                $data['attachment'] = $photo;
            }
            //$this->erp->print_arrays($data, $products, $payment);
        }

        if ($this->form_validation->run() == true && $this->sales_model->returnSale($data, $products, $payment)) {
            $this->session->set_flashdata('message', lang("return_sale_added"));
            redirect("sales/return_sales");
        } else {

            $this->data['error'] = (validation_errors() ? validation_errors() : $this->session->flashdata('error'));
			$inv = $this->sales_model->getInvoiceByID($id);
            $this->data['inv'] = $inv;
            if ($this->data['inv']->sale_status != 'completed') {
                $this->session->set_flashdata('error', lang("sale_status_x_competed"));
                redirect($_SERVER["HTTP_REFERER"]);
            }
            $inv_items = $this->sales_model->getAllInvoiceItems($id);
            $c = rand(100000, 9999999);
            foreach ($inv_items as $item) {
                $row = $this->site->getProductByID($item->product_id);
                if (!$row) {
                    $row = json_decode('{}');
                    $row->tax_method = 0;
                    $row->quantity = 0;
                } else {
                    unset($row->details, $row->product_details, $row->cost, $row->supplier1price, $row->supplier2price, $row->supplier3price, $row->supplier4price, $row->supplier5price);
                }
                $pis = $this->sales_model->getPurchasedItems($item->product_id, $item->warehouse_id, $item->option_id);
                if($pis){
                    foreach ($pis as $pi) {
                        $row->quantity += $pi->quantity_balance;
                    }
                }
                $row->id = $item->product_id;
                $row->sale_item_id = $item->id;
                $row->code = $item->product_code;
                $row->name = $item->product_name;
                $row->type = $item->product_type;
                $row->qty = $item->quantity;
                $row->oqty = $item->quantity;
                $row->discount = $item->discount ? $item->discount : '0';
                $row->price = $this->erp->formatDecimal($item->net_unit_price+$this->erp->formatDecimal($item->item_discount/$item->quantity));
                $row->unit_price = $row->tax_method ? $item->unit_price+$this->erp->formatDecimal($item->item_discount/$item->quantity)+$this->erp->formatDecimal($item->item_tax/$item->quantity) : $item->unit_price+($item->item_discount/$item->quantity);
                $row->real_unit_price = $item->real_unit_price;
				$row->cost = $item->cost;
                $row->tax_rate = $item->tax_rate_id;
                $row->serial = $item->serial_no;
                $row->option = $item->option_id;
                $options = $this->sales_model->getProductOptions($row->id, $item->warehouse_id, TRUE);
                $ri = $this->Settings->item_addition ? $row->id : $c;
                if ($row->tax_rate) {
                    $tax_rate = $this->site->getTaxRateByID($row->tax_rate);
                    $pr[$ri] = array('id' => $c, 'item_id' => $row->id, 'label' => $row->name . " (" . $row->code . ")", 'row' => $row, 'tax_rate' => $tax_rate, 'options' => $options);
                } else {
                    $pr[$ri] = array('id' => $c, 'item_id' => $row->id, 'label' => $row->name . " (" . $row->code . ")", 'row' => $row, 'tax_rate' => false, 'options' => $options);
                }
                $c++;
            }
            $this->data['inv_items'] = json_encode($pr);
            $this->data['id'] = $id;
            $this->data['payment_ref'] = $this->site->getReference('pp');
			$this->data['billers'] = $this->site->getAllCompanies('biller');
            $this->data['warehouses'] = $this->site->getAllWarehouses();
            $this->data['tax_rates'] = $this->site->getAllTaxRates();
			$this->data['agencies'] = $this->site->getAllUsers();
			$this->data['customers'] = $this->site->getCustomers();
			$this->data['currency'] = $this->site->getCurrency();
            $this->data['reference'] = $this->site->getReference('re',$inv->biller_id);
            $this->data['tax_rates'] = $this->site->getAllTaxRates();
			$this->data['setting'] = $this->site->get_setting();
			$this->data['bankAccounts'] =  $this->site->getAllBankAccounts();
            $bc = array(array('link' => base_url(), 'page' => lang('home')), array('link' => site_url('sales'), 'page' => lang('sales')), array('link' => '#', 'page' => lang('return_sale')));
            $meta = array('page_title' => lang('return_sale'), 'bc' => $bc);
            $this->page_construct('sales/return_sale', $meta, $this->data);
        }
    }

    
	/* Add Return Sale  */
	function add_return($quote_id = NULL)
    {
        $this->erp->checkPermissions('return_sales',null,'sales');

        $this->form_validation->set_message('is_natural_no_zero', lang("no_zero_required"));
        //$this->form_validation->set_rules('reference_no', lang("reference_no"), 'required');
        $this->form_validation->set_rules('customer', lang("customer"), 'required');
        $this->form_validation->set_rules('biller', lang("biller"), 'required');
        //$this->form_validation->set_rules('sale_status', lang("sale_status"), 'required');
        //$this->form_validation->set_rules('payment_status', lang("payment_status"), 'required');
		
		if($this->input->post('payment_status') == 'paid'){
			$this->form_validation->set_rules('amount-paid', lang("amount"), 'required');
		}

        if ($this->form_validation->run() == true) {
            $sale = $this->sales_model->getInvoiceByRef($quote_id);
			
			$warehouse_id = $this->input->post('warehouse');
            $customer_id = $this->input->post('customer');
			$biller_id = $this->input->post('biller');
			
			$customer_details = $this->site->getCompanyByID($customer_id);
			$customer = $customer_details->company ? $customer_details->company : $customer_details->name;
			$biller_details = $this->site->getCompanyByID($biller_id);
            $biller = $biller_details->company != '-' ? $biller_details->company : $biller_details->name;
			
            $quantity = "quantity";
            $product = "product";
            $unit_cost = "unit_cost";
            $tax_rate = "tax_rate";
            $reference = $this->input->post('reference_no') ? $this->input->post('reference_no') : $this->site->getReference('re');
            if ($this->Owner || $this->Admin) {
                $date = $this->erp->fld(trim($this->input->post('date')));
            } else {
                $date = date('Y-m-d H:i:s');
            }

            $return_surcharge = $this->input->post('return_surcharge') ? $this->input->post('return_surcharge') : 0;
            $note = $this->erp->clear_tags($this->input->post('note'));

            $total = 0;
            $product_tax = 0;
            $order_tax = 0;
            $product_discount = 0;
            $order_discount = 0;
            $percentage = '%';
            $i = isset($_POST['product_code']) ? sizeof($_POST['product_code']) : 0;
            for ($r = 0; $r < $i; $r++) {
                $item_id = $_POST['product_id'][$r];
                $item_type = $_POST['product_type'][$r];
                $item_code = $_POST['product_code'][$r];
                $item_name = $_POST['product_name'][$r];
                $sale_ref = $_POST['sale_reference'][$r];
				if(!$sale_ref){
					$sample_sale_ref = $this->sales_model->getSampleSaleRefByProductID($item_id);
					$sale_ref = $sample_sale_ref;
				}
				
                $item_option = isset($_POST['product_option'][$r]) && $_POST['product_option'][$r] != 'false' ? $_POST['product_option'][$r] : NULL;
                //$option_details = $this->sales_model->getProductOptionByID($item_option);
                $real_unit_price = $this->erp->formatDecimal($_POST['real_unit_price'][$r]);
                $unit_price = $this->erp->formatDecimal($_POST['unit_price'][$r]);
                $item_quantity = $_POST['quantity'][$r];
                $item_serial = isset($_POST['serial'][$r]) ? $_POST['serial'][$r] : '';
                $item_tax_rate = isset($_POST['product_tax'][$r]) ? $_POST['product_tax'][$r] : NULL;
                $item_discount = isset($_POST['product_discount'][$r]) ? $_POST['product_discount'][$r] : NULL;
				
				$sale_r = $this->sales_model->getSaleItemByRefPID($sale_ref, $item_id);
				if(!$sale_r) {
					$sale_r = $this->sales_model->getSaleItemByProductID($item_id);
				}
				$sale_item_id = $sale_r->sale_item_id;
                $sale_id = $sale_r->sale_id?$sale_r->sale_id:0;

                if (isset($item_code) && isset($real_unit_price) && isset($unit_price) && isset($item_quantity)) {
                    $product_details = $item_type != 'manual' ? $this->sales_model->getProductByCode($item_code) : NULL;
                    if (isset($item_discount)) {
                        $discount = $item_discount;
                        $dpos = strpos($discount, $percentage);
                        if ($dpos !== false) {
                            $pds = explode("%", $discount);
                            $pr_discount = (($this->erp->formatDecimal($unit_price)) * (Float)($pds[0])) / 100;
                        } else {
                            $pr_discount = $this->erp->formatDecimal($discount);
                        }
                    } else {
                        $pr_discount = 0;
                    }
                    $unit_price = $this->erp->formatDecimal($unit_price - $pr_discount);
                    $pr_item_discount = $this->erp->formatDecimal($pr_discount * $item_quantity);
                    $product_discount += $pr_item_discount;

                    if (isset($item_tax_rate) && $item_tax_rate != 0) {
                        $pr_tax = $item_tax_rate;
                        $tax_details = $this->site->getTaxRateByID($pr_tax);
                        if ($tax_details->type == 1 && $tax_details->rate != 0) {
                            if (!$product_details->tax_method) {
                                $item_tax = $this->erp->formatDecimal((($unit_price) * $tax_details->rate) / (100 + $tax_details->rate));
                                $tax = $tax_details->rate . "%";
                            } else {
                                $item_tax = $this->erp->formatDecimal((($unit_price) * $tax_details->rate) / 100);
                                $tax = $tax_details->rate . "%";
                            }
                        } elseif ($tax_details->type == 2) {
                            $item_tax = $this->erp->formatDecimal($tax_details->rate);
                            $tax = $tax_details->rate;
                        }
                        $pr_item_tax = $this->erp->formatDecimal($item_tax * $item_quantity);
                    } else {
                        $pr_tax = 0;
                        $pr_item_tax = 0;
                        $tax = "";
                    }
                    
                    $item_net_price = $product_details->tax_method ? $this->erp->formatDecimal($unit_price-$pr_discount) : $this->erp->formatDecimal($unit_price-$item_tax-$pr_discount);
                    $product_tax += $pr_item_tax;
                    $subtotal = (($item_net_price * $item_quantity) + $pr_item_tax);
                    $products[] = array(
                        'product_id' => $item_id,
                        'product_code' => $item_code,
                        'product_name' => $item_name,
                        'product_type' => $item_type,
                        'option_id' => $item_option,
                        'net_unit_price' => $item_net_price,
                        // 'unit_price' => $this->erp->formatDecimal($item_net_price + $item_tax),
                        'quantity' => $item_quantity,
                        'warehouse_id' => $warehouse_id,
                        'item_tax' => $pr_item_tax,
                        'tax_rate_id' => $pr_tax,
                        'tax' => $tax,
                        'discount' => $item_discount,
                        'item_discount' => $pr_item_discount,
                        'subtotal' => $this->erp->formatDecimal($subtotal),
                        'serial_no' => $item_serial,
                        'real_unit_price' => $real_unit_price,
                        'sale_item_id' => $sale_item_id,
                        'sale_id' => $sale_id
                    );
                    $total += $item_net_price * $item_quantity;
                }
            }
            if (empty($products)) {
                $this->form_validation->set_rules('product', lang("order_items"), 'required');
            } else {
                krsort($products);
            }
			
			$paid_amount = $this->input->post('amount-paid');

            if ($this->input->post('discount')) {
                $order_discount_id = $this->input->post('order_discount');
                $opos = strpos($order_discount_id, $percentage);
                if ($opos !== false) {
                    $ods = explode("%", $order_discount_id);
                    $order_discount = $this->erp->formatDecimal((($paid_amount + $product_tax) * (Float)($ods[0])) / 100);
                } else {
                    $order_discount = $this->erp->formatDecimal($order_discount_id);
                }
            } else {
                $order_discount_id = NULL;
            }
            $total_discount = $order_discount + $product_discount;

            if ($this->Settings->tax2) {
                $order_tax_id = $this->input->post('order_tax');
                if ($order_tax_details = $this->site->getTaxRateByID($order_tax_id)) {
                    if ($order_tax_details->type == 2) {
                        $order_tax = $this->erp->formatDecimal($order_tax_details->rate);
                    }
                    if ($order_tax_details->type == 1) {
                        $order_tax = $this->erp->formatDecimal((($paid_amount + $product_tax - $order_discount) * $order_tax_details->rate) / 100);
                    }
                }
            } else {
                $order_tax_id = NULL;
            }
			
			$references = sizeof($_POST['sale_reference']);

            $total_tax = $this->erp->formatDecimal($product_tax + $order_tax);
            $grand_total = $this->erp->formatDecimal($paid_amount);
            $data = array('date' => $date,
                'sale_id' => $quote_id,
                'reference_no' => $reference,
                'customer_id' => $customer_id,
                'customer' => $customer,
                'biller_id' => $biller_id,
                'biller' => $biller,
                'warehouse_id' => $warehouse_id,
                'note' => $note,
                'total' => $this->input->post('amount-paid'),
                'product_discount' => $this->erp->formatDecimal($product_discount),
                'order_discount_id' => $order_discount_id,
                'order_discount' => $order_discount,
                'total_discount' => $total_discount,
                'product_tax' => $this->erp->formatDecimal($product_tax),
                'order_tax_id' => $order_tax_id,
                'order_tax' => $order_tax,
                'total_tax' => $total_tax,
                'surcharge' => $this->erp->formatDecimal($return_surcharge),
                'grand_total' => $grand_total,
                'created_by' => $this->session->userdata('user_id')
            );
            if ($this->input->post('amount-paid') && $this->input->post('amount-paid') != 0) {
                $payment = array(
                    'date' => $date,
                    'reference_no' => $this->input->post('payment_reference_no'),
                    'amount' => $this->erp->formatDecimal($this->input->post('amount-paid')),
                    'paid_by' => $this->input->post('paid_by'),
                    'cheque_no' => $this->input->post('cheque_no'),
                    'cc_no' => $this->input->post('pcc_no'),
                    'cc_holder' => $this->input->post('pcc_holder'),
                    'cc_month' => $this->input->post('pcc_month'),
                    'cc_year' => $this->input->post('pcc_year'),
                    'cc_type' => $this->input->post('pcc_type'),
                    'created_by' => $this->session->userdata('user_id'),
                    'type' => 'returned',
                    'biller_id' => $sale->biller_id ? $sale->biller_id : $this->default_biller_id,
					'add_payment' => '0'
                );
            } else {
                $payment = array();
            }

            if ($_FILES['document']['size'] > 0) {
                $this->load->library('upload');
                $config['upload_path'] = $this->digital_upload_path;
                $config['allowed_types'] = $this->digital_file_types;
                $config['max_size'] = $this->allowed_file_size;
                $config['overwrite'] = FALSE;
                $config['encrypt_name'] = TRUE;
                $this->upload->initialize($config);
                if (!$this->upload->do_upload('document')) {
                    $error = $this->upload->display_errors();
                    $this->session->set_flashdata('error', $error);
                    redirect($_SERVER["HTTP_REFERER"]);
                }
                $photo = $this->upload->file_name;
                $data['attachment'] = $photo;
            }
            //$this->erp->print_arrays($data, $products, $payment);
        }

        if ($this->form_validation->run() == true && $this->sales_model->returnSales($data, $products, $payment)) {
            $this->session->set_flashdata('message', lang("return_sale_added"));
            redirect("sales/return_sales");
        } else {

            if ($quote_id) {
                $this->data['quote'] = $this->sales_model->getQuoteByID($quote_id);
                $items = $this->sales_model->getAllQuoteItems($quote_id);
                $c = rand(100000, 9999999);
                foreach ($items as $item) {
                    $row = $this->site->getProductByID($item->product_id);
                    if (!$row) {
                        $row = json_decode('{}');
                        $row->tax_method = 0;
                    } else {
                        unset($row->cost, $row->details, $row->product_details, $row->supplier1price, $row->supplier2price, $row->supplier3price, $row->supplier4price, $row->supplier5price);
                    }
                    $row->quantity = 0;
                    $pis = $this->sales_model->getPurchasedItems($item->product_id, $item->warehouse_id, $item->option_id);
                    if($pis){
                        foreach ($pis as $pi) {
                            $row->quantity += $pi->quantity_balance;
                        }
                    }
                    $row->id = $item->product_id;
                    $row->code = $item->product_code;
                    //$row->name = $item->product_name;
                    $row->type = $item->product_type;
                    $row->qty = $item->quantity;
                    $row->discount = $item->discount ? $item->discount : '0';
                    $row->price = $this->erp->formatDecimal($item->net_unit_price+$this->erp->formatDecimal($item->item_discount/$item->quantity));
                    $row->unit_price = $row->tax_method ? $item->unit_price+$this->erp->formatDecimal($item->item_discount/$item->quantity)+$this->erp->formatDecimal($item->item_tax/$item->quantity) : $item->unit_price+($item->item_discount/$item->quantity);
                    $row->real_unit_price = $item->real_unit_price;
                    $row->tax_rate = $item->tax_rate_id;
                    $row->serial = '';
                    $row->option = $item->option_id;

                    $options = $this->sales_model->getProductOptions($row->id, $item->warehouse_id);

                    if ($options) {
                        $option_quantity = 0;
                        foreach ($options as $option) {
                            $pis = $this->sales_model->getPurchasedItems($row->id, $item->warehouse_id, $item->option_id);
                            if($pis){
                                foreach ($pis as $pi) {
                                    $option_quantity += $pi->quantity_balance;
                                }
                            }
                            if($option->quantity > $option_quantity) {
                                $option->quantity = $option_quantity;
                            }
                        }
                    }
                    $combo_items = FALSE;
                    if ($row->type == 'combo') {
                        $combo_items = $this->sales_model->getProductComboItems($row->id, $item->warehouse_id);
                    }
                    $ri = $this->Settings->item_addition ? $row->id : $c;
                    if ($row->tax_rate) {
                        $tax_rate = $this->site->getTaxRateByID($row->tax_rate);
                        $pr[$ri] = array('id' => $c, 'item_id' => $row->id, 'label' => $row->name . " (" . $row->code . ")", 'row' => $row, 'combo_items' => $combo_items, 'tax_rate' => $tax_rate, 'options' => $options, 'sale_ref' => '', 'quantity_received' => 0);
                    } else {
                        $pr[$ri] = array('id' => $c, 'item_id' => $row->id, 'label' => $row->name . " (" . $row->code . ")", 'row' => $row, 'combo_items' => $combo_items, 'tax_rate' => false, 'options' => $options, 'sale_ref' => '', 'quantity_received' => 0);
                    }
                    $c++;
                }
                $this->data['quote_items'] = json_encode($pr);
            }

            $this->data['error'] = (validation_errors() ? validation_errors() : $this->session->flashdata('error'));
            $this->data['quote_id'] = $quote_id;
            $this->data['billers'] = $this->site->getAllCompanies('biller');
            $this->data['warehouses'] = $this->site->getAllWarehouses();
			
			$this->data['agencies'] = $this->site->getAllUsers();
            $this->data['tax_rates'] = $this->site->getAllTaxRates();
            //$this->data['currencies'] = $this->sales_model->getAllCurrencies();
            $this->data['slnumber'] = ''; //$this->site->getReference('so');
            $this->data['payment_ref'] = $this->site->getReference('sp');
			$this->data['setting'] = $this->site->get_setting();
            $bc = array(array('link' => base_url(), 'page' => lang('home')), array('link' => site_url('sales'), 'page' => lang('sales')), array('link' => '#', 'page' => lang('add_sale_return')));
            $meta = array('page_title' => lang('add_sale_return'), 'bc' => $bc);
            $this->page_construct('sales/add_return', $meta, $this->data);
        }
    
	}

	function getReferences($term = NULL, $limit = NULL)
    {
       
        if ($this->input->get('term')) {
            $term = $this->input->get('term', TRUE);
        }
        if (strlen($term) < 1) {
            return FALSE;
        }
        $limit = $this->input->get('limit', TRUE);
		
        $rows['results'] = $this->sales_model->getSalesReferences($term, $limit);
        echo json_encode($rows);
    }
	
    function delete($id = NULL)
    {
        $this->erp->checkPermissions('delete',null,'sales');

        if ($this->input->get('id')) {
            $id = $this->input->get('id');
        }
        if ($this->sales_model->deleteSale($id) && $this->sales_model->deleteDelivery($id)) {
            if($this->input->is_ajax_request()) {
                echo lang("sale_deleted"); die();
            }
            $this->session->set_flashdata('message', lang('sale_deleted'));
            redirect('welcome');
        }
    }

    function delete_return($id = NULL)
    {
        $this->erp->checkPermissions(NULL, TRUE);

        if ($this->input->get('id')) {
            $id = $this->input->get('id');
        }

        if ($this->sales_model->deleteReturn($id)) {
            if($this->input->is_ajax_request()) {
                echo lang("return_sale_deleted"); die();
            }
            $this->session->set_flashdata('message', lang('return_sale_deleted'));
            redirect('welcome');
        }
    }

    function sale_actions()
    {
        if (!$this->Owner) {
            $this->session->set_flashdata('warning', lang('access_denied'));
            redirect($_SERVER["HTTP_REFERER"]);
        }

        $this->form_validation->set_rules('form_action', lang("form_action"), 'required');

        if ($this->form_validation->run() == true) {

            if (!empty($_POST['val'])) {
                if ($this->input->post('form_action') == 'delete') {
                    foreach ($_POST['val'] as $id) {
                        $this->sales_model->deleteSale($id);
                    }
					$this->session->set_flashdata('message', lang('sale_deleted'));
					redirect($_SERVER["HTTP_REFERER"]);
                }
                
                if ($this->input->post('form_action') == 'combine_pay') {
                    //$html = $this->combine_pdf($_POST['val']);
                }

                if ($this->input->post('form_action') == 'export_excel' || $this->input->post('form_action') == 'export_pdf') {

                    $this->load->library('excel');
                    $this->excel->setActiveSheetIndex(0);
                    $this->excel->getActiveSheet()->setTitle(lang('sales'));
                    $this->excel->getActiveSheet()->SetCellValue('A1', lang('date'));
                    $this->excel->getActiveSheet()->SetCellValue('B1', lang('quote_no'));
                    $this->excel->getActiveSheet()->SetCellValue('C1', lang('so_no'));
                    $this->excel->getActiveSheet()->SetCellValue('D1', lang('sales_num'));
                    $this->excel->getActiveSheet()->SetCellValue('E1', lang('project'));
                    $this->excel->getActiveSheet()->SetCellValue('F1', lang('customer'));
                    $this->excel->getActiveSheet()->SetCellValue('G1', lang('saleman'));
                    $this->excel->getActiveSheet()->SetCellValue('H1', lang('sale_status'));
                    $this->excel->getActiveSheet()->SetCellValue('I1', lang('grand_total'));
                    $this->excel->getActiveSheet()->SetCellValue('J1', lang('deposit'));
                    $this->excel->getActiveSheet()->SetCellValue('K1', lang('paid'));
                    $this->excel->getActiveSheet()->SetCellValue('L1', lang('balance'));
                    $this->excel->getActiveSheet()->SetCellValue('M1', lang('payment_status'));
					$styleArray = array(
                        'borders' => array(
                            'allborders' => array(
                                'style' => PHPExcel_Style_Border::BORDER_THIN
                            )
                        )
                    );
                    $row = 2;
                    foreach ($_POST['val'] as $id) {
                        $sale = $this->sales_model->getInvoiceByID($id);
                        $sum_grand += $sale->grand_total;
                        $balance = $sale->grand_total - $sale->paid;
                        $sum_banlance += $balance;
                        $sum_deposit += $sale->deposit;
                        $sum_paid += $sale->paid;
                        $this->excel->getActiveSheet()->SetCellValue('A' . $row, $this->erp->hrld($sale->date));
                        $this->excel->getActiveSheet()->SetCellValue('B' . $row, $sale->quote_no." ");
                        $this->excel->getActiveSheet()->SetCellValue('C' . $row, $sale->so_no." ");
                        $this->excel->getActiveSheet()->SetCellValue('D' . $row, $sale->reference_no." ");
                        $this->excel->getActiveSheet()->SetCellValue('E' . $row, $sale->biller);
                        $this->excel->getActiveSheet()->SetCellValue('F' . $row, $sale->customer);
                        $this->excel->getActiveSheet()->SetCellValue('G' . $row, $sale->saleman);
                        $this->excel->getActiveSheet()->SetCellValue('H' . $row, $sale->sale_status);
                        $this->excel->getActiveSheet()->SetCellValue('I' . $row, $sale->grand_total);
                        $this->excel->getActiveSheet()->SetCellValue('J' . $row, $sale->deposit);
                        $this->excel->getActiveSheet()->SetCellValue('K' . $row, $sale->paid);
                        $this->excel->getActiveSheet()->SetCellValue('L' . $row, $balance);
                        $this->excel->getActiveSheet()->SetCellValue('M' . $row, $sale->payment_status);
                        $new_row = $row+1;
                            $this->excel->getActiveSheet()->SetCellValue('I' . $new_row, $sum_grand);
                            $this->excel->getActiveSheet()->SetCellValue('J' . $new_row, $sum_deposit);
                            $this->excel->getActiveSheet()->SetCellValue('K' . $new_row, $sum_paid);
                            $this->excel->getActiveSheet()->SetCellValue('L' . $new_row, $sum_banlance);
                        $row++;
                    }
                    $this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(20);
                    $this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
                    $this->excel->getDefaultStyle()->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                    $filename = 'sales_' . date('Y_m_d_H_i_s');
                    if ($this->input->post('form_action') == 'export_pdf') {
                        $styleArray = array('borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN)));
                        $this->excel->getDefaultStyle()->applyFromArray($styleArray);
                        $this->excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
                        require_once(APPPATH . "third_party" . DIRECTORY_SEPARATOR . "MPDF" . DIRECTORY_SEPARATOR . "mpdf.php");
                        $rendererName = PHPExcel_Settings::PDF_RENDERER_MPDF;
                        $rendererLibrary = 'MPDF';
                        $rendererLibraryPath = APPPATH . 'third_party' . DIRECTORY_SEPARATOR . $rendererLibrary;
                        if (!PHPExcel_Settings::setPdfRenderer($rendererName, $rendererLibraryPath)) {
                            die('Please set the $rendererName: ' . $rendererName . ' and $rendererLibraryPath: ' . $rendererLibraryPath . ' values' .
                                PHP_EOL . ' as appropriate for your directory structure');
                        }

                        header('Content-Type: application/pdf');
                        header('Content-Disposition: attachment;filename="' . $filename . '.pdf"');
                        header('Cache-Control: max-age=0');

                        $this->excel->getActiveSheet()->getStyle('I' . $new_row.'')->getFont()->setBold(true);
                        $this->excel->getActiveSheet()->getStyle('J' . $new_row.'')->getFont()->setBold(true);
                        $this->excel->getActiveSheet()->getStyle('L' . $new_row.'')->getFont()->setBold(true);
                        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'PDF');
                        return $objWriter->save('php://output');
                    }
                    if ($this->input->post('form_action') == 'export_excel') {
                        header('Content-Type: application/vnd.ms-excel');
                        header('Content-Disposition: attachment;filename="' . $filename . '.xls"');
                        header('Cache-Control: max-age=0');

                        $this->excel->getActiveSheet()->getStyle('I' . $new_row.'')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border:: BORDER_THIN);
                        $this->excel->getActiveSheet()->getStyle('I' . $new_row.'')->getFont()->setBold(true);
                        $this->excel->getActiveSheet()->getStyle('J' . $new_row.'')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border:: BORDER_THIN);
                        $this->excel->getActiveSheet()->getStyle('J' . $new_row.'')->getFont()->setBold(true);
                        $this->excel->getActiveSheet()->getStyle('K' . $new_row.'')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border:: BORDER_THIN);
                        $this->excel->getActiveSheet()->getStyle('K' . $new_row.'')->getFont()->setBold(true);
                        $this->excel->getActiveSheet()->getStyle('L' . $new_row.'')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border:: BORDER_THIN);
                        $this->excel->getActiveSheet()->getStyle('L' . $new_row.'')->getFont()->setBold(true);

                        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
                        return $objWriter->save('php://output');
                    }

                    redirect($_SERVER["HTTP_REFERER"]);
                }
            } else {
                $this->session->set_flashdata('error', lang("no_sale_selected"));
                redirect($_SERVER["HTTP_REFERER"]);
            }
        } else {
            $this->session->set_flashdata('error', validation_errors());
            redirect($_SERVER["HTTP_REFERER"]);
        }
    }
	
	function suspend_actions()
    {
		
        if (!$this->Owner) {
            $this->session->set_flashdata('warning', lang('access_denied'));
            redirect($_SERVER["HTTP_REFERER"]);
        }

        $this->form_validation->set_rules('form_action', lang("form_action"), 'required');

        if ($this->form_validation->run() == true) {
            if (!empty($_POST['val'])) {
                if ($this->input->post('form_action') == 'delete') {
                    foreach ($_POST['val'] as $id) {
                        $this->sales_model->deleteSuspend($id);
                    }
                    $this->session->set_flashdata('message', lang("sales_deleted"));
                    redirect($_SERVER["HTTP_REFERER"]);
                }

                if ($this->input->post('form_action') == 'export_excel' || $this->input->post('form_action') == 'export_pdf') {

                    $this->load->library('excel');
                    $this->excel->setActiveSheetIndex(0);
                    $this->excel->getActiveSheet()->setTitle(lang('sales'));
                    $this->excel->getActiveSheet()->SetCellValue('A1', lang('date'));
                    $this->excel->getActiveSheet()->SetCellValue('B1', lang('reference_no'));
                    $this->excel->getActiveSheet()->SetCellValue('C1', lang('biller'));
                    $this->excel->getActiveSheet()->SetCellValue('D1', lang('customer'));
                    $this->excel->getActiveSheet()->SetCellValue('E1', lang('grand_total'));
                    $this->excel->getActiveSheet()->SetCellValue('F1', lang('paid'));
                    $this->excel->getActiveSheet()->SetCellValue('G1', lang('payment_status'));

                    $row = 2;
                    foreach ($_POST['val'] as $id) {
                        $sale = $this->sales_model->getInvoiceByID($id);
                        $this->excel->getActiveSheet()->SetCellValue('A' . $row, $this->erp->hrld($sale->date));
                        $this->excel->getActiveSheet()->SetCellValue('B' . $row, $sale->reference_no);
                        $this->excel->getActiveSheet()->SetCellValue('C' . $row, $sale->biller);
                        $this->excel->getActiveSheet()->SetCellValue('D' . $row, $sale->customer);
                        $this->excel->getActiveSheet()->SetCellValue('E' . $row, $sale->grand_total);
                        $this->excel->getActiveSheet()->SetCellValue('F' . $row, $sale->paid);
                        $this->excel->getActiveSheet()->SetCellValue('G' . $row, $sale->payment_status);
                        $row++;
                    }

                    $this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(20);
                    $this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
                    $this->excel->getDefaultStyle()->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                    $filename = 'sales_' . date('Y_m_d_H_i_s');
                    if ($this->input->post('form_action') == 'export_pdf') {
                        $styleArray = array('borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN)));
                        $this->excel->getDefaultStyle()->applyFromArray($styleArray);
                        $this->excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
                        require_once(APPPATH . "third_party" . DIRECTORY_SEPARATOR . "MPDF" . DIRECTORY_SEPARATOR . "mpdf.php");
                        $rendererName = PHPExcel_Settings::PDF_RENDERER_MPDF;
                        $rendererLibrary = 'MPDF';
                        $rendererLibraryPath = APPPATH . 'third_party' . DIRECTORY_SEPARATOR . $rendererLibrary;
                        if (!PHPExcel_Settings::setPdfRenderer($rendererName, $rendererLibraryPath)) {
                            die('Please set the $rendererName: ' . $rendererName . ' and $rendererLibraryPath: ' . $rendererLibraryPath . ' values' .
                                PHP_EOL . ' as appropriate for your directory structure');
                        }

                        header('Content-Type: application/pdf');
                        header('Content-Disposition: attachment;filename="' . $filename . '.pdf"');
                        header('Cache-Control: max-age=0');

                        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'PDF');
                        return $objWriter->save('php://output');
                    }
                    if ($this->input->post('form_action') == 'export_excel') {
                        header('Content-Type: application/vnd.ms-excel');
                        header('Content-Disposition: attachment;filename="' . $filename . '.xls"');
                        header('Cache-Control: max-age=0');

                        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
                        return $objWriter->save('php://output');
                    }

                    redirect($_SERVER["HTTP_REFERER"]);
                }
            } else {
                $this->session->set_flashdata('error', lang("no_sale_selected"));
                redirect($_SERVER["HTTP_REFERER"]);
            }
        } else {
            $this->session->set_flashdata('error', validation_errors());
            redirect($_SERVER["HTTP_REFERER"]);
        }
    }

    /* ------------------------------- */
		
	function deliveries($start_date = NULL, $end_date = NULL)
    {
        $this->erp->checkPermissions();
		
		if (!$start_date) {
            //$start = $this->db->escape(date('Y-m') . '-1');
           // $start_date = date('Y-m') . '-1';
        } else {
            $start = $this->db->escape(urldecode($start_date));
        }
        if (!$end_date) {
            //$end = $this->db->escape(date('Y-m-d H:i'));
            //$end_date = date('Y-m-d H:i');
        } else {
            $end = $this->db->escape(urldecode($end_date));
        }

        $data['error'] = (validation_errors() ? validation_errors() : $this->session->flashdata('error'));
		
		$this->data['start'] = urldecode($start_date);
        $this->data['end'] = urldecode($end_date);
		
        $bc = array(array('link' => base_url(), 'page' => lang('home')), array('link' => site_url('sales'), 'page' => lang('sales')), array('link' => '#', 'page' => lang('deliveries')));
        $meta = array('page_title' => lang('deliveries'), 'bc' => $bc);
        $this->page_construct('sales/deliveries', $meta, $this->data);
    }
    
	function deliveries_alerts($date = NULL, $start_date = NULL, $end_date = NULL)
    {
        $this->erp->checkPermissions();

		$date = $date;
		
		if (!$start_date) {
            //$start = $this->db->escape(date('Y-m') . '-1');
            //$start_date = date('Y-m') . '-1';
        } else {
            $start = $this->db->escape(urldecode($start_date));
        }
        if (!$end_date) {
            //$end = $this->db->escape(date('Y-m-d H:i'));
           // $end_date = date('Y-m-d H:i');
        } else {
            $end = $this->db->escape(urldecode($end_date));
        }

		
		$this->data['date'] = $date;
        $data['error'] = (validation_errors() ? validation_errors() : $this->session->flashdata('error'));
		
		$this->data['start'] = urldecode($start_date);
        $this->data['end'] = urldecode($end_date);
		
        $bc = array(array('link' => base_url(), 'page' => lang('home')), array('link' => site_url('sales'), 'page' => lang('sales')), array('link' => '#', 'page' => lang('deliveries_alerts')));
        $meta = array('page_title' => lang('deliveries_alerts'), 'bc' => $bc);
        $this->page_construct('sales/deliveries_alerts', $meta, $this->data);

    }
	/*===============================================chin local updated===================================*/
    function getDeliveries($start = NULL, $end = NULL)
    {
        $this->erp->checkPermissions('deliveries');

		$print_cabon_link = anchor('sales/view_delivery_cabon/$1', '<i class="fa fa-file-text-o"></i> ' . lang('print_cabon'), 'data-toggle="modal" data-target="#myModal"');
        $detail_link = anchor('sales/view_delivery/$1', '<i class="fa fa-file-text-o"></i> ' . lang('delivery_details'), 'data-toggle="modal" data-target="#myModal"');
        $email_link = anchor('sales/email_delivery/$1', '<i class="fa fa-envelope"></i> ' . lang('email_delivery'), 'data-toggle="modal" data-target="#myModal"');
        $edit_link = anchor('sales/edit_deliveries/$1', '<i class="fa fa-edit"></i> ' . lang('edit_delivery'));
        $pdf_link = anchor('sales/pdf_delivery/$1', '<i class="fa fa-file-pdf-o"></i> ' . lang('download_pdf'));
        $delete_link = "<a href='#' class='po' title='<b>" . lang("delete_delivery") . "</b>' data-content=\"<p>"
            . lang('r_u_sure') . "</p><a class='btn btn-danger po-delete' href='" . site_url('sales/delete_delivery/$1') . "'>"
            . lang('i_m_sure') . "</a> <button class='btn po-close'>" . lang('no') . "</button>\"  rel='popover'><i class=\"fa fa-trash-o\"></i> "
            . lang('delete_delivery') . "</a>";
        $action = '<div class="text-center"><div class="btn-group text-left">'
            . '<button type="button" class="btn btn-default btn-xs btn-primary dropdown-toggle" data-toggle="dropdown">'
            . lang('actions') . ' <span class="caret"></span></button>
    <ul class="dropdown-menu pull-right" role="menu">
        <!--<li>' . $print_cabon_link . '</li>-->
		<li>' . $detail_link . '</li>'
		
		.(($this->Owner || $this->Admin) ? '<li>'.$edit_link.'</li>' : ($this->GP['sales-edit_delivery'] ? '<li>'.$edit_link.'</li>' : '')).
        
		'<li>' . $pdf_link . '</li>
        <!--<li>' . $delete_link . '</li>-->
    </ul>
</div></div>';

        $user_id = $this->session->userdata('user_id');
        $biller_id = $this->session->userdata('biller_id');

        $this->load->library('datatables');
        if ($biller_id) {
    		$this->datatables
                ->select("deliveries.id as id, deliveries.date, deliveries.do_reference_no, deliveries.sale_reference_no, 
    					cust.name as customer_name, 
    					cust.address, COALESCE(SUM(erp_delivery_items.quantity_received),0) as qty, deliveries.delivery_status as de_sale_status")
                ->from('deliveries')
                ->join('users', 'deliveries.created_by = users.id', 'left')
                ->join('delivery_items', 'delivery_items.delivery_id = deliveries.id', 'inner')
    			->join('companies as erp_cust', 'cust.id = deliveries.customer_id', 'inner')
                ->where('type','invoice')
                ->where('deliveries.biller_id', $biller_id)
                ->group_by('deliveries.id');
        } else {
            $this->datatables
                ->select("deliveries.id as id, deliveries.date, deliveries.do_reference_no, deliveries.sale_reference_no, 
                        cust.name as customer_name, 
                        cust.address, COALESCE(SUM(erp_delivery_items.quantity_received),0) as qty, deliveries.delivery_status as de_sale_status")
                ->from('deliveries')
                ->where('type','invoice')
                ->join('delivery_items', 'delivery_items.delivery_id = deliveries.id', 'inner')
                ->join('companies as erp_cust', 'cust.id = deliveries.customer_id', 'inner')
                ->group_by('deliveries.id');
        }
		
		if($start && $end){
			$this->datatables->where('date BETWEEN "' . $start . '" AND "' . $end . '"');
		}
		
        $this->datatables->add_column("Actions", $action, "id");

        echo $this->datatables->generate();
    }
	
	function getSaleOrderDeliveries($start = NULL, $end = NULL)
    {
        $this->erp->checkPermissions('deliveries');

		$print_cabon_link = anchor('sales/view_delivery_cabon/$1', '<i class="fa fa-file-text-o"></i> ' . lang('print_cabon'), 'data-toggle="modal" data-target="#myModal"');
        $detail_link = anchor('sales/view_delivery/$1', '<i class="fa fa-file-text-o"></i> ' . lang('delivery_details'), 'data-toggle="modal" data-target="#myModal"');
        $email_link = anchor('sales/email_delivery/$1', '<i class="fa fa-envelope"></i> ' . lang('email_delivery'), 'data-toggle="modal" data-target="#myModal"');
        $edit_link = anchor('sales/edit_deliveries/$1', '<i class="fa fa-edit"></i> ' . lang('edit_delivery'));
		$add_link = anchor('sales/add/0/$1', '<i class="fa fa-plus-circle"></i> ' . lang('add_sale'));
        $pdf_link = anchor('sales/pdf_delivery/$1', '<i class="fa fa-file-pdf-o"></i> ' . lang('download_pdf'));
        $delete_link = "<a href='#' class='po' title='<b>" . lang("delete_delivery") . "</b>' data-content=\"<p>"
						. lang('r_u_sure') . "</p><a class='btn btn-danger po-delete' href='" . site_url('sales/delete_delivery/$1') . "'>"
						. lang('i_m_sure') . "</a> <button class='btn po-close'>" . lang('no') . "</button>\"  rel='popover'><i class=\"fa fa-trash-o\"></i> "
						. lang('delete_delivery') . "</a>";
        $action =  '<div class="text-center"><div class="btn-group text-left">'
								. '<button type="button" class="btn btn-default btn-xs btn-primary dropdown-toggle" data-toggle="dropdown">'
								. lang('actions') . ' <span class="caret"></span></button>
						<ul class="dropdown-menu pull-right" role="menu">
							<!--<li>' . $print_cabon_link . '</li>-->
							<li>' . $detail_link . '</li>'
							.(($this->Owner || $this->Admin) ? '<li>'.$edit_link.'</li>' : ($this->GP['sales-edit_delivery'] ? '<li>'.$edit_link.'</li>' : '')).
							
							'<li>' . $pdf_link . '</li>
							<li>' . $add_link . '</li>
							<!--<li>' . $delete_link . '</li>-->
						</ul>
					</div></div>';

        $this->load->library('datatables');
        //GROUP_CONCAT(CONCAT('Name: ', sale_items.product_name, ' Qty: ', sale_items.quantity ) SEPARATOR '<br>')
		
		$this->datatables
            ->select("deliveries.id as id, deliveries.date, deliveries.do_reference_no, deliveries.sale_reference_no, companies.name as customer_name, deliveries.address, COALESCE(SUM(erp_delivery_items.quantity_received),0) as qty, deliveries.sale_status")
            ->from('deliveries')
			->where('type','sale_order')
            ->join('delivery_items', 'delivery_items.delivery_id = deliveries.id', 'left')
			->join('companies', 'companies.id = deliveries.customer_id', 'inner')
            ->group_by('deliveries.id')
			->order_by('deliveries.id', 'desc');
		if($start && $end){
			$this->datatables->where('date BETWEEN "' . $start . '" AND "' . $end . '"');
		}
		
        $this->datatables->add_column("Actions", $action, "id");
        echo $this->datatables->generate();
    }
	/*====================================================end local updated=======================================*/	
	
	function getDeliveriesAlert($date = NULL,$start = NULL, $end = NULL)
    {
        $this->erp->checkPermissions('deliveries_alerts');

        $detail_link = anchor('sales/view_delivery/$1', '<i class="fa fa-file-text-o"></i> ' . lang('delivery_details'), 'data-toggle="modal" data-target="#myModal"');
        $email_link = anchor('sales/email_delivery/$1', '<i class="fa fa-envelope"></i> ' . lang('email_delivery'), 'data-toggle="modal" data-target="#myModal"');
        $edit_link = anchor('sales/edit_delivery/$1', '<i class="fa fa-edit"></i> ' . lang('edit_delivery'), 'data-toggle="modal" data-target="#myModal"');
        $pdf_link = anchor('sales/pdf_delivery/$1', '<i class="fa fa-file-pdf-o"></i> ' . lang('download_pdf'));
        $delete_link = "<a href='#' class='po' title='<b>" . lang("delete_delivery") . "</b>' data-content=\"<p>"
            . lang('r_u_sure') . "</p><a class='btn btn-danger po-delete' href='" . site_url('sales/delete_delivery/$1') . "'>"
            . lang('i_m_sure') . "</a> <button class='btn po-close'>" . lang('no') . "</button>\"  rel='popover'><i class=\"fa fa-trash-o\"></i> "
            . lang('delete_delivery') . "</a>";
        $action = '<div class="text-center"><div class="btn-group text-left">'
            . '<button type="button" class="btn btn-default btn-xs btn-primary dropdown-toggle" data-toggle="dropdown">'
            . lang('actions') . ' <span class="caret"></span></button>
    <ul class="dropdown-menu pull-right" role="menu">
        <li>' . $detail_link . '</li>
        <li>' . $edit_link . '</li>
        <li>' . $pdf_link . '</li>
        <li>' . $delete_link . '</li>
    </ul>
</div></div>';

        $this->load->library('datatables');
        //GROUP_CONCAT(CONCAT('Name: ', sale_items.product_name, ' Qty: ', sale_items.quantity ) SEPARATOR '<br>')
		
		$this->datatables
            ->select("deliveries.id as id, date, do_reference_no, sale_reference_no, customer, address, COALESCE(SUM(erp_sale_items.quantity),0) as qty, delivery_status")
            ->from('deliveries')
            ->join('sale_items', 'sale_items.sale_id=deliveries.sale_id', 'left')
            ->group_by('deliveries.id');
		
		if($date){
			$this->datatables->where('date >=', $date)
				->where('delivery_status =', 'pending');
		}
		
		if($start && $end){
			$this->datatables->where('date BETWEEN "' . $start . '" AND "' . $end . '"');
		}
		
        $this->datatables->add_column("Actions", $action, "id");

        echo $this->datatables->generate();
    }

    function view_delivery_combine($id = NULL)
    {
        $this->erp->checkPermissions('deliveries');

        $arr = array();
        if ($this->input->get('data'))
        {
            $arr = explode(',', $this->input->get('data'));
        }

        $this->data['error'] = (validation_errors() ? validation_errors() : $this->session->flashdata('error'));
        $deli = $this->sales_model->getDeliveryByID($id);

        $this->data['delivery'] = $deli;
        $sale = $this->sales_model->getInvoiceByID($deli->sale_id);
        $this->data['biller'] = $this->site->getCompanyByID($sale->biller_id);
       
        $data = array();
        for( $i = 0 ; $i < count($arr); $i ++){
            $deliv = $this->sales_model->getDeliveryByID($arr[$i]);
            $data[] = $deliv->sale_id;
        }

        $this->data['rows'] = $this->sales_model->getAllInvoiceItemsWithDetails($data);
		$this->data['combo_details'] = $this->sales_model->getProductComboItemsCode($data);
        $this->data['user'] = $this->site->getUser($deli->created_by);
        $this->data['page_title'] = lang("delivery_order");

        $this->load->view($this->theme . 'sales/view_delivery_combine', $this->data);
    }
    
	function pdf_delivery($id = NULL, $view = NULL, $save_bufffer = NULL)
    {
        $this->erp->checkPermissions();

        if ($this->input->get('id')) {
            $id = $this->input->get('id');
        }
        $this->data['error'] = (validation_errors() ? validation_errors() : $this->session->flashdata('error'));
        $deli = $this->sales_model->getDeliveryByID($id);
        $this->data['delivery'] = $deli;
        $sale = $this->sales_model->getInvoiceByID($deli->delivery_id);
        $this->data['biller'] = $this->site->getCompanyByID($sale->biller_id);
        $this->data['rows'] = $this->sales_model->getAllDeliInvoiceItems($deli->delivery_id);
        $this->data['user'] = $this->site->getUser($deli->created_by);
		//$this->erp->print_arrays($this->sales_model->getAllDeliInvoiceItems($deli->delivery_id));

        $name = lang("delivery") . "_" . str_replace('/', '_', $deli->do_reference_no) . ".pdf";
        $html = $this->load->view($this->theme . 'sales/pdf_delivery', $this->data, TRUE);
        if ($view) {
            $this->load->view($this->theme . 'sales/pdf_delivery', $this->data);
        } elseif ($save_bufffer) {
            return $this->erp->generate_pdf($html, $name, $save_bufffer);
        } else {
            $this->erp->generate_pdf($html, $name);
        }
    }
	
	function view_delivery_cabon($id = NULL)
    {
        $this->erp->checkPermissions('deliveries');

        if ($this->input->get('id')) {
            $id = $this->input->get('id');
        }

        $this->data['error'] = (validation_errors() ? validation_errors() : $this->session->flashdata('error'));
        $deli = $this->sales_model->getDeliveryByID($id);

        $this->data['delivery'] = $deli;
        $sale = $this->sales_model->getInvoiceByID($deli->sale_id);
        $this->data['biller'] = $this->site->getCompanyByID($sale->biller_id);
        $this->data['rows'] = $this->sales_model->getAllInvoiceItemsWithDetails($deli->sale_id);
        $this->data['user'] = $this->site->getUser($deli->created_by);
        $this->data['page_title'] = lang("delivery_order");
        $this->load->view($this->theme . 'sales/view_delivery_cabon', $this->data);
    }
    
	function view_delivery_old($id = NULL)
    {
        $this->erp->checkPermissions('deliveries');
        if ($this->input->get('id')) {
            $id = $this->input->get('id');
        }
		
        $this->data['error'] = (validation_errors() ? validation_errors() : $this->session->flashdata('error'));
        $deli = $this->sales_model->getSaleDeliveryByID($id);
        $this->data['delivery'] = $deli;
        $sale = $this->sales_model->getInvoiceByID($deli->sale_id);
        $this->data['biller'] = $this->site->getCompanyByID($sale->biller_id);
        $this->data['rows'] = $this->sales_model->getAllDeliveryInvoiceItems($id);
		//$this->erp->print_arrays($this->data['rows']);
		$this->data['setting'] = $this->site->get_setting();
        $this->data['user'] = $this->site->getUser($deli->created_by);
        $this->data['page_title'] = lang("delivery_order");
        $this->load->view($this->theme . 'sales/view_delivery', $this->data);
    }
	function view_delivery($id = NULL)
    {
        $this->erp->checkPermissions('deliveries');
        if ($this->input->get('id')) {
            $id = $this->input->get('id');
        }
		
        $this->data['error'] = (validation_errors() ? validation_errors() : $this->session->flashdata('error'));
        $deli = $this->sales_model->getSaleDeliveryByID($id);
        $this->data['delivery'] = $deli;
        $sale = $this->sales_model->getInvoiceByID($deli->sale_id);
        $this->data['biller'] = $this->site->getCompanyByID($sale->biller_id);
        $this->data['rows'] = $this->sales_model->getAllDeliveryInvoiceItems($id);
		
		$this->data['setting'] = $this->site->get_setting();
        $this->data['user'] = $this->site->getUser($deli->created_by);
        $this->data['page_title'] = lang("delivery_order");
        $this->load->view($this->theme . 'sales/view_delivery', $this->data);
    }
	
	
	function sale_order_view_delivery($id = NULL)
    {
        $this->erp->checkPermissions();
        if ($this->input->get('id')) {
            $id = $this->input->get('id');
        }
		
        $this->data['error'] = (validation_errors() ? validation_errors() : $this->session->flashdata('error'));
        $deli = $this->sales_model->getSaleOrderDeliveryByID($id);
        $this->data['delivery'] = $deli;
        $sale = $this->sales_model->getSaleInvoiceByID($deli->sale_id);
        $this->data['biller'] = $this->site->getCompanyByID($sale->biller_id);
        $this->data['rows'] = $this->sales_model->getAllDeliveryInvoiceItems($id);
		$this->data['setting'] = $this->site->get_setting();
        $this->data['user'] = $this->site->getUser($deli->created_by);
        $this->data['page_title'] = lang("delivery_order");
        $this->data['deli'] = $deli;  
        $this->load->view($this->theme . 'sales/view_delivery', $this->data);
    }
	

    function add_delivery($id = NULL)
    {
        $this->erp->checkPermissions();

        if ($this->input->get('id')) {
            $id = $this->input->get('id');
        }

        //$this->form_validation->set_rules('do_reference_no', lang("do_reference_no"), 'required');
        $this->form_validation->set_rules('sale_reference_no', lang("sale_reference_no"), 'required');
        $this->form_validation->set_rules('customer', lang("customer"), 'required');
        $this->form_validation->set_rules('address', lang("address"), 'required');

        if ($this->form_validation->run() == true) {
            if ($this->Owner || $this->Admin) {
                $date = $this->erp->fld(trim($this->input->post('date')));
            } else {
                $date = date('Y-m-d H:i:s');
            }
			$do_reference_no = $this->input->post('do_reference_no') ? $this->input->post('do_reference_no') : $this->site->getReference('do');
			$sale_reference_no = $this->input->post('sale_reference_no');
			$sale_delivery_status = $this->input->post('sale_delivery_status');
			$customer = $this->input->post('customer');
			$address = $this->input->post('address');
			$note = $this->erp->clear_tags($this->input->post('note'));
			
            $dlDetails = array(
                'date' => $date,
                'sale_id' => $this->input->post('sale_id'),
                'do_reference_no' => $do_reference_no,
                'sale_reference_no' => $sale_reference_no,
				'delivery_status' => $sale_delivery_status,
                'customer' => $customer,
                'address' => $address,
                'note' => $note,
                'created_by' => $this->session->userdata('user_id'),
            );
			//$this->erp->print_arrays($dlDetails);
        } elseif ($this->input->post('add_delivery')) {
            $this->session->set_flashdata('error', validation_errors());
            redirect($_SERVER["HTTP_REFERER"]);
        }


        if ($this->form_validation->run() == true && $this->sales_model->addDelivery($dlDetails)) {
            $this->session->set_flashdata('message', lang("delivery_added"));
            redirect("sales/deliveries");
        } else {

            $this->data['error'] = (validation_errors() ? validation_errors() : $this->session->flashdata('error'));

            $sale = $this->sales_model->getInvoiceByID($id);
            $this->data['customer'] = $this->site->getCompanyByID($sale->customer_id);
            $this->data['inv'] = $sale;
            $this->data['do_reference_no'] = ''; //$this->site->getReference('do');
            $this->data['modal_js'] = $this->site->modal_js();

            $this->load->view($this->theme . 'sales/add_delivery', $this->data);
        }
    }
	
    function edit_delivery($id = NULL)
    {
        $this->erp->checkPermissions();

        if ($this->input->get('id')) {
            $id = $this->input->get('id');
        }

        $this->form_validation->set_rules('do_reference_no', lang("do_reference_no"), 'required');
        $this->form_validation->set_rules('sale_reference_no', lang("sale_reference_no"), 'required');
        $this->form_validation->set_rules('customer', lang("customer"), 'required');
        $this->form_validation->set_rules('address', lang("address"), 'required');
        //$this->form_validation->set_rules('note', lang("note"), 'xss_clean');

        if ($this->form_validation->run() == true) {

            $dlDetails = array(
                'sale_id' => $this->input->post('sale_id'),
                'do_reference_no' => $this->input->post('do_reference_no'),
                'sale_reference_no' => $this->input->post('sale_reference_no'),
                'customer' => $this->input->post('customer'),
                'address' => $this->input->post('address'),
                'note' => $this->erp->clear_tags($this->input->post('note')),
                'created_by' => $this->session->userdata('user_id'),
				'delivery_status' => $this->input->post('sale_delivery_status')
            );

            if ($this->Owner || $this->Admin) {
                $date = $this->erp->fld(trim($this->input->post('date')));
                $dlDetails['date'] = $date;
            }
        } elseif ($this->input->post('edit_delivery')) {
            $this->session->set_flashdata('error', validation_errors());
            redirect($_SERVER["HTTP_REFERER"]);
        }


        if ($this->form_validation->run() == true && $this->sales_model->updateDelivery($id, $dlDetails)) {
            $this->session->set_flashdata('message', lang("delivery_updated"));
            redirect("sales/deliveries");
        } else {

            $this->data['error'] = (validation_errors() ? validation_errors() : $this->session->flashdata('error'));


            $this->data['delivery'] = $this->sales_model->getDeliveryByID($id);
            $this->data['modal_js'] = $this->site->modal_js();

            $this->load->view($this->theme . 'sales/edit_delivery', $this->data);
        }
    }

    function delete_delivery($id = NULL)
    {
        $this->erp->checkPermissions(NULL, TRUE);

        if ($this->input->get('id')) {
            $id = $this->input->get('id');
        }

        if ($this->sales_model->deleteDelivery($id)) {
			
            echo lang("delivery_deleted");
        }

    }

    function delivery_actions()
    {
        if (!$this->Owner) {
            $this->session->set_flashdata('warning', lang('access_denied'));
            redirect($_SERVER["HTTP_REFERER"]);
        }

        $this->form_validation->set_rules('form_action', lang("form_action"), 'required');

        if ($this->form_validation->run() == true) {

            if (!empty($_POST['val'])) {
                if ($this->input->post('form_action') == 'delete') {
                    foreach ($_POST['val'] as $id) {
                        $this->sales_model->deleteDelivery($id);
                    }
                    $this->session->set_flashdata('message', lang("deliveries_deleted"));
                    redirect($_SERVER["HTTP_REFERER"]);
                }
				
				if ($this->input->post('form_action') == 'completed_delivery') {
                    foreach ($_POST['val'] as $id) {
                        $this->sales_model->completedDeliveries($id);
                    }
                    $this->session->set_flashdata('message', lang("deliveries_completed"));
                    redirect($_SERVER["HTTP_REFERER"]);
                }
				
				if ($this->input->post('form_action') == 'add_sale_combine_deliveries') {
					$delivery_id = $_POST['val'];
					
					if ($delivery_id){
						
						$sale_order = $this->sales_model->getDeliveriesByIDs($delivery_id);
						
						
						//$this->erp->print_arrays($sale_order);
						$this->data['sale_order'] = $sale_order;
						$this->data['refer'] = $sale_order->sale_reference_no;
						$items = $this->sales_model->getDeliveryItemsByItemIds($delivery_id);
						
						$deli_gp_id = "";
						for($i=0;$i<count($delivery_id);$i++)
						{
							if($i==0){
								$deli_gp_id.=$delivery_id[$i];
							}else{
								$deli_gp_id.=",".$delivery_id[$i];
							}
						}
						
						$this->data['delivery_id'] = $deli_gp_id;
						$this->data['type'] = "delivery";
						$this->data['type_id'] = $deli_gp_id;
						$customer = $this->site->getCompanyByID($sale_order->customer_id);
						$c = rand(100000, 9999999);
						foreach ($items as $item) {
							$row = $this->site->getProductByID($item->product_id);
							if (!$row) {
								$row = json_decode('{}');
								$row->tax_method = 0;
							} else {
								unset($row->details, $row->product_details, $row->supplier1price, $row->supplier2price, $row->supplier3price, $row->supplier4price, $row->supplier5price);
							}
							$row->quantity = 0;
							$pis = $this->sales_model->getPurchasedItems($item->product_id, $item->warehouse_id, $item->option_id);
							if($pis){
								foreach ($pis as $pi) {
									$row->quantity += $pi->quantity_balance;
								}
							}
							$row->id = $item->product_id;
							$row->code = $item->product_code;
							//$row->name = $item->product_name;
							$row->type = $item->product_type;
							$row->qty = $item->dqty_received;
							$row->discount = $item->discount ? $item->discount : '0';
							$row->price = $this->erp->formatDecimal($item->net_unit_price+$this->erp->formatDecimal($item->item_discount/$item->quantity));
							$row->unit_price = $row->tax_method ? $item->unit_price+$this->erp->formatDecimal($item->item_discount/$item->quantity)+$this->erp->formatDecimal($item->item_tax/$item->quantity) : $item->unit_price+($item->item_discount/$item->quantity);
							$row->real_unit_price = $item->real_unit_price;
							$row->tax_rate = $item->tax_rate_id;
							$row->serial = '';
							$row->option = $item->option_id;
							
							$group_prices = $this->sales_model->getProductPriceGroup($item->product_id, $customer->price_group_id);
							$all_group_prices = $this->sales_model->getProductPriceGroup($item->product_id);
							$row->price_id = 0;
							
							$options = $this->sales_model->getProductOptions($row->id, $item->warehouse_id);
							if ($options) {
								$option_quantity = 0;
								foreach ($options as $option) {
									$pis = $this->sales_model->getPurchasedItems($row->id, $item->warehouse_id, $item->option_id);
									if($pis){
										foreach ($pis as $pi) {
											$option_quantity += $pi->quantity_balance;
										}
									}
									if($option->quantity > $option_quantity) {
										$option->quantity = $option_quantity;
									}
								}
							}
							$combo_items = FALSE;
							if ($row->type == 'combo') {
								$combo_items = $this->sales_model->getProductComboItems($row->id, $item->warehouse_id);
							}
							$ri = $this->Settings->item_addition ? $row->id : $c;
							if ($row->tax_rate) {
								$tax_rate = $this->site->getTaxRateByID($row->tax_rate);
								$pr[$ri] = array('id' => $c, 'item_id' => $row->id, 'label' => $row->name . " (" . $row->code . ")", 'row' => $row, 'combo_items' => $combo_items, 'tax_rate' => $tax_rate, 'options' => $options, 'makeup_cost' => 0,'group_prices'=>$group_prices, 'all_group_price' => $all_group_prices);
							} else {
								$pr[$ri] = array('id' => $c, 'item_id' => $row->id, 'label' => $row->name . " (" . $row->code . ")", 'row' => $row, 'combo_items' => $combo_items, 'tax_rate' => false, 'options' => $options, 'makeup_cost' => 0,'group_prices'=>$group_prices, 'all_group_price' => $all_group_prices);
							}
							$c++;
						}
						$this->data['sale_order_items'] = json_encode($pr);
						
						
						$this->data['exchange_rate'] = $this->site->getCurrencyByCode('KHM');
						$this->data['error'] = (validation_errors() ? validation_errors() : $this->session->flashdata('error'));
						$this->data['billers'] = $this->site->getAllCompanies('biller');
						$this->data['warehouses'] = $this->site->getAllWarehouses();
						$this->data['tax_rates'] = $this->site->getAllTaxRates();
						$this->data['drivers'] = $this->site->getAllCompanies('driver');
						$this->data['agencies'] = $this->site->getAllUsers();
						$this->data['customers'] = $this->site->getCustomers();
						$this->data['currency'] = $this->site->getCurrency();
						$this->data['areas'] = $this->site->getArea();
						$this->data['payment_term'] = $this->site->getAllPaymentTerm();
						$this->data['bankAccounts'] =  $this->site->getAllBankAccounts();
						$this->data['slnumber'] = '';
						$this->data['reference'] = $this->site->getReference('so');
						$this->data['payment_ref'] = $this->site->getReference('sp');
						$this->data['setting'] = $this->site->get_setting();
						$this->session->set_userdata('remove_s', 0);
						$bc = array(array('link' => base_url(), 'page' => lang('home')), array('link' => site_url('sales'), 'page' => lang('sales')), array('link' => '#', 'page' => lang('add_sale')));
						$meta = array('page_title' => lang('add_sale'), 'bc' => $bc);
						$this->page_construct('sales/add', $meta, $this->data);
						
					}
				}

                if ($this->input->post('form_action') == 'export_excel' || $this->input->post('form_action') == 'export_pdf') {

                    $this->load->library('excel');
                    $this->excel->setActiveSheetIndex(0);
                    $this->excel->getActiveSheet()->setTitle(lang('deliveries'));
                    $this->excel->getActiveSheet()->SetCellValue('A1', lang('date'));
                    $this->excel->getActiveSheet()->SetCellValue('B1', lang('do_reference_no'));
                    $this->excel->getActiveSheet()->SetCellValue('C1', lang('sale_reference_no'));
                    $this->excel->getActiveSheet()->SetCellValue('D1', lang('customer'));
                    $this->excel->getActiveSheet()->SetCellValue('E1', lang('address'));
                    $this->excel->getActiveSheet()->SetCellValue('F1', lang('quantity'));
                    $this->excel->getActiveSheet()->SetCellValue('G1', lang('issue_status'));

                    $row = 2;
                    foreach ($_POST['val'] as $id) {
                        $delivery = $this->sales_model->getDeliveryByID($id);
                        $sum_qty += $delivery->quantity;
                        $this->excel->getActiveSheet()->SetCellValue('A' . $row, $this->erp->hrld($delivery->date));
                        $this->excel->getActiveSheet()->SetCellValue('B' . $row, $delivery->do_reference_no." ");
                        $this->excel->getActiveSheet()->SetCellValue('C' . $row, $delivery->sale_reference_no." ");
                        $this->excel->getActiveSheet()->SetCellValue('D' . $row, $delivery->customer);
                        $this->excel->getActiveSheet()->SetCellValue('E' . $row, $delivery->address);
                        $this->excel->getActiveSheet()->SetCellValue('F' . $row, $delivery->quantity);
                        $this->excel->getActiveSheet()->SetCellValue('G' . $row, $delivery->sale_status);
                        $new_row = $row+1;
                        $this->excel->getActiveSheet()->SetCellValue('F' . $new_row, $sum_qty);
                        $row++;
                    }

                    $this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(20);
                    $this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(20);

                    $filename = 'deliveries_' . date('Y_m_d_H_i_s');
                    if ($this->input->post('form_action') == 'export_pdf') {
                        $styleArray = array('borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN)));
                        $this->excel->getDefaultStyle()->applyFromArray($styleArray);
                        $this->excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
                        require_once(APPPATH . "third_party" . DIRECTORY_SEPARATOR . "MPDF" . DIRECTORY_SEPARATOR . "mpdf.php");
                        $rendererName = PHPExcel_Settings::PDF_RENDERER_MPDF;
                        $rendererLibrary = 'MPDF';
                        $rendererLibraryPath = APPPATH . 'third_party' . DIRECTORY_SEPARATOR . $rendererLibrary;
                        if (!PHPExcel_Settings::setPdfRenderer($rendererName, $rendererLibraryPath)) {
                            die('Please set the $rendererName: ' . $rendererName . ' and $rendererLibraryPath: ' . $rendererLibraryPath . ' values' .
                                PHP_EOL . ' as appropriate for your directory structure');
                        }

                        header('Content-Type: application/pdf');
                        header('Content-Disposition: attachment;filename="' . $filename . '.pdf"');
                        header('Cache-Control: max-age=0');

                        $this->excel->getActiveSheet()->getStyle('F' . $new_row.'')->getFont()->setBold(true);

                        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'PDF');
                        return $objWriter->save('php://output');
                    }
                    if ($this->input->post('form_action') == 'export_excel') {
                        header('Content-Type: application/vnd.ms-excel');
                        header('Content-Disposition: attachment;filename="' . $filename . '.xls"');
                        header('Cache-Control: max-age=0');

                        $this->excel->getActiveSheet()->getStyle('F' . $new_row.'')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border:: BORDER_THIN);
                        $this->excel->getActiveSheet()->getStyle('F' . $new_row.'')->getFont()->setBold(true);
                        
                        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
                        return $objWriter->save('php://output');
                    }

                    redirect($_SERVER["HTTP_REFERER"]);
                }
            } else {
                $this->session->set_flashdata('error', lang("no_delivery_selected"));
                redirect($_SERVER["HTTP_REFERER"]);
            }
        } else {
            $this->session->set_flashdata('error', validation_errors());
            redirect($_SERVER["HTTP_REFERER"]);
        }
    }

    /* -------------------------------------------------------------------------------- */

    function payments($id = NULL)
    {
        $this->erp->checkPermissions(false, true);
		$inv = $this->sales_model->getInvoiceByID($id);
		$payments = $this->sales_model->getCurrentBalance($inv->id);
		$current_balance = $inv->grand_total;
		foreach($payments as $curr_pay) {
			//if ($curr_pay->id < $id) {
				$current_balance -= $curr_pay->amount;
			//}
		}
		
		$this->data['curr_balance'] = $current_balance;
        $this->data['payments'] = $this->sales_model->getInvoicePayments($id);
        $this->load->view($this->theme . 'sales/payments', $this->data);
    }

    function payment_note($id = NULL)
    {
        $payment = $this->sales_model->getPaymentByID($id);
        $inv = $this->sales_model->getInvoiceByID($payment->sale_id);
        $this->data['biller'] = $this->site->getCompanyByID($inv->biller_id);
        $this->data['customer'] = $this->site->getCompanyByID($inv->customer_id);
        $this->data['inv'] = $inv;
		
		$payments = $this->sales_model->getCurrentBalance($inv->id);
		$current_balance = $inv->grand_total;
		foreach($payments as $curr_pay) {
			if ($curr_pay->id < $id) {
				$current_balance -= ($curr_pay->amount-$curr_pay->extra_paid);
			}
		}
		$this->data['curr_balance'] = $current_balance;
		
		/* Apartment */
		$this->data['rows'] = $this->sales_model->getAllInvoiceItems($inv->id);
		$this->data['exchange_rate_kh_c'] = $this->pos_model->getExchange_rate('KHM');
		/* / */
		
        $this->data['payment'] = $payment;
        $this->data['page_title'] = $this->lang->line("payment_note");
		
        $this->load->view($this->theme . 'sales/payment_note', $this->data);
    }

    function add_payment($id = NULL)
    {
        $this->erp->checkPermissions('payments', true);
        $this->load->helper('security');
        if ($this->input->get('id')) {
            $id = $this->input->get('id');
        }

        //$this->form_validation->set_rules('reference_no', lang("reference_no"), 'required');
        $this->form_validation->set_rules('amount-paid', lang("amount"), 'required');
        $this->form_validation->set_rules('paid_by', lang("paid_by"), 'required');
        $this->form_validation->set_rules('userfile', lang("attachment"), 'xss_clean');
        if ($this->form_validation->run() == true) {
			
            if ($this->Owner || $this->Admin) {
                $date = $this->erp->fld(trim($this->input->post('date')));
            } else {
                $date = date('Y-m-d H:i:s');
            }
			$sale_id = $this->input->post('sale_id');
			$sale_ref = $this->sales_model->getSaleById($sale_id)->reference_no; 
			$paid_by = $this->input->post('paid_by');
			$biller_id = $this->input->post('biller');
			$reference_no = $this->input->post("sale_id");
			
			if($paid_by == "deposit"){
				$payment_reference = $sale_ref;
			}else{
				$payment_reference = (($paid_by == 'deposit')? $this->site->getReference('pay',$biller_id):($this->input->post('reference_no') ? $this->input->post('reference_no') : $this->site->getReference('sp',$biller_id)));
			}
			
			$paid_amount = $this->input->post('amount-paid');
			$customer_id = $this->input->post('customer');
			$customer = '';
			if($customer_id) {
				$customer_details = $this->site->getCompanyByID($customer_id);
				$customer = $customer_details->company ? $customer_details->company : $customer_details->name;
			}
			$note = ($this->input->post('note')? $this->input->post('note'):($customer? $customer:$this->input->post('customer_name')));
			
			$payment = array(
                'date' => $date,
                'sale_id' => $sale_id,
                'reference_no' => $payment_reference,
                'amount' => $paid_amount,
                'paid_by' => $paid_by,
                'cheque_no' => $this->input->post('cheque_no'),
                'cc_no' => $paid_by == 'gift_card' ? $this->input->post('gift_card_no') : $this->input->post('pcc_no'),
                'cc_holder' => $this->input->post('pcc_holder'),
                'cc_month' => $this->input->post('pcc_month'),
                'cc_year' => $this->input->post('pcc_year'),
                'cc_type' => $this->input->post('pcc_type'),
                'note' => $note,
                'created_by' => $this->session->userdata('user_id'),
                'type' => 'received',
				'biller_id'	=> $biller_id,
				'deposit_customer_id' => $this->input->post('customer'),
				'add_payment' => '1',
				'bank_account' => $this->input->post('bank_account')
            );
			
			//$this->erp->print_arrays($payment);
			
            if ($_FILES['userfile']['size'] > 0) {
                $this->load->library('upload');
                $config['upload_path'] = $this->upload_path;
                $config['allowed_types'] = $this->digital_file_types;
                $config['max_size'] = $this->allowed_file_size;
                $config['overwrite'] = FALSE;
                $config['encrypt_name'] = TRUE;
                $this->upload->initialize($config);
                if (!$this->upload->do_upload()) {
                    $error = $this->upload->display_errors();
                    $this->session->set_flashdata('error', $error);
                    redirect($_SERVER["HTTP_REFERER"]);
                }
                $photo = $this->upload->file_name;
                $payment['attachment'] = $photo;
            }

            //$this->erp->print_arrays($payment);

        } elseif ($this->input->post('add_payment')) {
            $this->session->set_flashdata('error', validation_errors());
            redirect($_SERVER["HTTP_REFERER"]);
        }

        if ($this->form_validation->run() == true && $payment_id = $this->sales_model->addPayment($payment)) {
			if($payment_id > 0) {
				//add deposit
				if($paid_by == "deposit"){
					$deposits = array(
						'date' => $date,
						'reference' => $payment_reference,
						'company_id' => $customer_id,
						'amount' => (-1) * $paid_amount,
						'paid_by' => $paid_by,
						'note' => $note,
						'created_by' => $this->session->userdata('user_id'),
						'biller_id' => $biller_id,
						'sale_id' => $sale_id,
						'payment_id' => $payment_id,
						'status' => 'paid'
					);
					
					$this->sales_model->add_deposit($deposits);
				}
			}
				
            $this->session->set_flashdata('message', lang("payment_added"));
            redirect($_SERVER["HTTP_REFERER"]);
        } else {

            $this->data['error'] = (validation_errors() ? validation_errors() : $this->session->flashdata('error'));
			$this->data['billers'] = $this->site->getAllCompanies('biller');
            $sale = $this->sales_model->getInvoiceByID($id);
            $this->data['inv'] = $sale;
            
			if ($this->Owner || $this->Admin || !$this->session->userdata('biller_id')) {
				$biller_id = $this->site->get_setting()->default_biller;
				$this->data['biller_id'] = $biller_id;
				$this->data['reference'] = $this->site->getReference('sp',$biller_id);
			} else {
				$biller_id = $this->session->userdata('biller_id');
				$this->data['biller_id'] = $biller_id;
				$this->data['reference'] = $this->site->getReference('sp',$biller_id);
			}
			
			
            $this->data['modal_js'] = $this->site->modal_js();
			$this->data['customers'] = $this->site->getCustomers();
			$this->data['bankAccounts'] =  $this->site->getAllBankAccounts();
            $this->load->view($this->theme . 'sales/add_payment', $this->data);
        }
    }
	
	function combine_payment()
    {
        $this->erp->checkPermissions('payments', true);
        $this->load->helper('security');
        $arr = array();
        
        if ($this->input->get('data'))
        {
            $arr = explode(',', $this->input->get('data'));
        }
        
        //$this->form_validation->set_rules('reference_no', lang("reference_no"), 'required');
        $this->form_validation->set_rules('amount-paid', lang("amount"), 'required');
        $this->form_validation->set_rules('paid_by', lang("paid_by"), 'required');
        $this->form_validation->set_rules('userfile', lang("attachment"), 'xss_clean');
        if ($this->form_validation->run() == true) {
            if ($this->Owner || $this->Admin) {
                $date = $this->erp->fld(trim($this->input->post('date')));
            } else {
                $date = date('Y-m-d H:i:s');
            }
            
            if ($_FILES['userfile']['size'] > 0) {
                $this->load->library('upload');
                $config['upload_path'] = $this->upload_path;
                $config['allowed_types'] = $this->digital_file_types;
                $config['max_size'] = $this->allowed_file_size;
                $config['overwrite'] = FALSE;
                $config['encrypt_name'] = TRUE;
                $this->upload->initialize($config);
                if (!$this->upload->do_upload()) {
                    $error = $this->upload->display_errors();
                    $this->session->set_flashdata('error', $error);
                    redirect($_SERVER["HTTP_REFERER"]);
                }
                $photo = $this->upload->file_name;
                //$payment['attachment'] = $photo;
            }
			$sale_id_arr = $this->input->post('sale_id');
			$amount_paid_arr = $this->input->post('amount_paid_line');
			$i = 0;
			$reference_no = $this->input->post('reference_no') ? $this->input->post('reference_no') : $this->site->getReference('sp');
			foreach($sale_id_arr as $sale_id){
			
				$payment = array(
					'date' => $date,
					'sale_id' => $sale_id,
					'reference_no' => $reference_no,
					'amount' => $amount_paid_arr[$i],
					'paid_by' => $this->input->post('paid_by'),
					'cheque_no' => $this->input->post('cheque_no'),
					'cc_no' => $this->input->post('paid_by') == 'gift_card' ? $this->input->post('gift_card_no') : $this->input->post('pcc_no'),
					'cc_holder' => $this->input->post('pcc_holder'),
					'cc_month' => $this->input->post('pcc_month'),
					'cc_year' => $this->input->post('pcc_year'),
					'cc_type' => $this->input->post('pcc_type'),
					'note' => $this->input->post('note'),
					'created_by' => $this->session->userdata('user_id'),
					'type' => 'received',
					'biller_id'	=> $this->input->post('biller'),
					'attachment' =>$photo,
					'bank_account' => $this->input->post('bank_account')
				);
				$this->sales_model->addPayment($payment);
				$i++;
			}
			
            //$this->erp->print_arrays($payment);
			$this->session->set_flashdata('message', lang("payment_added"));
            redirect('account/list_ac_recevable');

        } else{
			$this->data['error'] = (validation_errors() ? validation_errors() : $this->session->flashdata('error'));
			$this->data['billers'] = $this->site->getAllCompanies('biller');
			$this->data['bankAccounts'] =  $this->site->getAllBankAccounts();
            $combine_payment = $this->sales_model->getCombinePaymentById($arr);
            $this->data['combine_sales'] = $combine_payment;
            $this->data['payment_ref'] = ''; //$this->site->getReference('sp');
            $this->data['modal_js'] = $this->site->modal_js();

            $this->load->view($this->theme . 'sales/combine_payment', $this->data);
		}
    }
	
	function combine_payment_old()
    {
        $this->erp->checkPermissions('payments', true);
        $this->load->helper('security');
        if ($this->input->get('id')) {
            $id = $this->input->get('id');
        }
        //$this->form_validation->set_rules('reference_no', lang("reference_no"), 'required');
		$this->form_validation->set_rules('form_action', lang("form_action"), 'required');
		
        $this->form_validation->set_rules('amount-paid', lang("amount"), 'required');
        $this->form_validation->set_rules('paid_by', lang("paid_by"), 'required');
        $this->form_validation->set_rules('userfile', lang("attachment"), 'xss_clean');
        if ($this->form_validation->run() == true) {
		   if (!empty($_POST['val'])) {
				if ($this->input->post('form_action') == 'delete') {
					foreach ($_POST['val'] as $id) {
						$this->data['error'] = (validation_errors() ? validation_errors() : $this->session->flashdata('error'));
						$this->data['billers'] = $this->site->getAllCompanies('biller');
						$this->data['get_minv'] = $this->sales_model->getmulti_InvoiceByID($id);
						$this->data['payment_ref'] = ''; //$this->site->getReference('sp');
				   ///  $this->data['modal_js'] = $this->site->modal_js();
					}
					$this->session->set_flashdata('message', lang("sales_deleted"));
					redirect($_SERVER["HTTP_REFERER"]);
				}
		   }
            if ($this->Owner || $this->Admin) {
                $date = $this->erp->fld(trim($this->input->post('date')));
            } else {
                $date = date('Y-m-d H:i:s');
            }
        } elseif ($this->input->post('combine_pay')) {
            $this->session->set_flashdata('error', validation_errors());
            redirect($_SERVER["HTTP_REFERER"]);
        }
        $this->load->view($this->theme . 'sales/combine_payment', $this->data);
    }
    
	function edit_payment($id = NULL)
    {
        $this->erp->checkPermissions('edit', true);
        $this->load->helper('security');
        if ($this->input->get('id')) {
            $id = $this->input->get('id');
        }

        //$this->form_validation->set_rules('reference_no', lang("reference_no"), 'required');
        $this->form_validation->set_rules('amount-paid', lang("amount"), 'required');
        $this->form_validation->set_rules('paid_by', lang("paid_by"), 'required');
        //$this->form_validation->set_rules('note', lang("note"), 'xss_clean');
        $this->form_validation->set_rules('userfile', lang("attachment"), 'xss_clean');
        if ($this->form_validation->run() == true) {
            if ($this->Owner || $this->Admin) {
                $date = $this->erp->fld(trim($this->input->post('date')));
            } else {
                $date = date('Y-m-d H:i:s');
            }
			$getpayment = $this->sales_model->getPaymentByID($id);
			$updated_count = $getpayment->updated_count + 1;
			$paid_by = $this->input->post('paid_by');
			$sale_id = $this->input->post('sale_id');
			$payment_reference = (($paid_by == 'deposit')? $this->input->post('sale_reference_no'):($this->input->post('reference_no') ? $this->input->post('reference_no') : $this->site->getReference('sp')));
            $paid_amount = $this->input->post('amount-paid');
			$biller_id = $this->input->post('biller');
			$customer_id = $this->input->post('customer');
			$customer = '';
			$deposit_id = $this->input->post('deposit_id');
			if($customer_id) {
				$customer_details = $this->site->getCompanyByID($customer_id);
				$customer = $customer_details->company ? $customer_details->company : $customer_details->name;
			}
			$note = ($this->input->post('note')? $this->input->post('note'):($customer? $customer:$this->input->post('customer_name')));
			
			if($getpayment->paid_by != 'deposit' && $paid_by == 'deposit') {
				$update_payment = array(
					'old_reference_no' => $getpayment->reference_no,
					'amount' => '0',
					'updated_by' => $this->session->userdata('user_id'),
					'updated_count' => $updated_count,
				);
			}else {
				$update_payment = array(
					'date' => $date,
					'sale_id' => $sale_id,
					'reference_no' => $payment_reference,
					'old_reference_no' => $getpayment->reference_no,
					'amount' => $paid_amount,
					'paid_by' => $paid_by,
					'cheque_no' => $this->input->post('cheque_no'),
					'cc_no' => $paid_by == 'gift_card' ? $this->input->post('gift_card_no') : $this->input->post('pcc_no'),
					'cc_holder' => $this->input->post('pcc_holder'),
					'cc_month' => $this->input->post('pcc_month'),
					'cc_year' => $this->input->post('pcc_year'),
					'cc_type' => $this->input->post('pcc_type'),
					'note' => $note,
					'updated_by' => $this->session->userdata('user_id'),
					'updated_count' => $updated_count,
					'type' => 'received',
					'biller_id'	=> $biller_id,
					'add_payment' => '1',
					'bank_account' => $this->input->post('bank_account')
				);
			}
			$add_payment = array();
			if($getpayment->paid_by != 'deposit' && $paid_by == 'deposit') {
				$add_payment = array(
					'date' => $date,
					'sale_id' => $sale_id,
					'reference_no' => $payment_reference,
					'amount' => $paid_amount,
					'paid_by' => $paid_by,
					'cheque_no' => $this->input->post('cheque_no'),
					'cc_no' => $paid_by == 'gift_card' ? $this->input->post('gift_card_no') : $this->input->post('pcc_no'),
					'cc_holder' => $this->input->post('pcc_holder'),
					'cc_month' => $this->input->post('pcc_month'),
					'cc_year' => $this->input->post('pcc_year'),
					'cc_type' => $this->input->post('pcc_type'),
					'note' => $note,
					'created_by' => $this->session->userdata('user_id'),
					'type' => 'received',
					'biller_id'	=> $biller_id,
					'add_payment' => '1',
					'bank_account' => $this->input->post('bank_account'),
					'deposit_customer_id' => $customer_id
				);
			}

            if ($_FILES['userfile']['size'] > 0) {
                $this->load->library('upload');
                $config['upload_path'] = $this->upload_path;
                $config['allowed_types'] = $this->digital_file_types;
                $config['max_size'] = $this->allowed_file_size;
                $config['overwrite'] = FALSE;
                $config['encrypt_name'] = TRUE;
                $this->upload->initialize($config);
                if (!$this->upload->do_upload()) {
                    $error = $this->upload->display_errors();
                    $this->session->set_flashdata('error', $error);
                    redirect($_SERVER["HTTP_REFERER"]);
                }
                $photo = $this->upload->file_name;
                $payment['attachment'] = $photo;
            }

			//$this->erp->print_arrays($update_payment, $add_payment);

        } elseif ($this->input->post('edit_payment')) {
            $this->session->set_flashdata('error', validation_errors());
            redirect($_SERVER["HTTP_REFERER"]);
        }

        if ($this->form_validation->run() == true && $payment_id = $this->sales_model->updatePayment($id, $update_payment, $add_payment)) {
			if($payment_id) {
				//update deposit
				if($paid_by == "deposit"){
					$deposits = array(
						'date' => $date,
						'reference' => $payment_reference,
						'company_id' => $customer_id,
						'amount' => (-1) * $paid_amount,
						'paid_by' => $paid_by,
						'note' => $note,
						'updated_by' => $this->session->userdata('user_id'),
						'biller_id' => $biller_id,
						'sale_id' => $sale_id,
						'payment_id' => $payment_id,
						'status' => 'paid'
					);
				}
				//$this->erp->print_arrays($deposit_id, $deposits);
				if($deposit_id && $getpayment->paid_by == 'deposit') {
					if($deposits) {
						$this->sales_model->updateDeposit($deposit_id, $deposits);
					}else {
						$this->sales_model->deleteDeposit($deposit_id);
					}
				}else {
					$this->sales_model->add_deposit($deposits);
				}				
			}
            $this->session->set_flashdata('message', lang("payment_updated"));
            redirect("sales");
        } else {
			$payment = $this->sales_model->getPaymentByID($id);
            $this->data['payment'] = $payment;
			$this->data['inv'] = $this->sales_model->getInvoiceByID($payment->sale_id);
			if($payment->paid_by == 'deposit') {
				$this->data['deposit'] = $this->sales_model->getDepositByPaymentID($payment->id);
			}
			$this->data['billers'] = $this->site->getAllCompanies('biller');
			$this->data['customers'] = $this->site->getCustomers();
			$this->data['reference'] = $this->site->getReference('sp');
			$this->data['bankAccounts'] =  $this->site->getAllBankAccounts();
			
            $this->data['modal_js'] = $this->site->modal_js();
            $this->data['error'] = (validation_errors() ? validation_errors() : $this->session->flashdata('error'));
            $this->load->view($this->theme . 'sales/edit_payment', $this->data);
        }
    }

    function delete_payment($id = NULL)
    {
        $this->erp->checkPermissions('delete');

        if ($this->input->get('id')) {
            $id = $this->input->get('id');
        }

        if ($this->sales_model->deletePayment($id)) {
			if($id) {
				$deposit = $this->sales_model->getDepositByPaymentID($id);
				if($deposit) {
					$this->sales_model->deleteDeposit($deposit->id);
				}
			}
            //echo lang("payment_deleted");
            $this->session->set_flashdata('message', lang("payment_deleted"));
            redirect($_SERVER["HTTP_REFERER"]);
        }
    }
	
	function add_payment_loan($data = NULL,$id = NULL,$paid_amount = NULL,$principle = NULL)
    {
		
        $this->erp->checkPermissions('payments', true);
        $this->load->helper('security');

        //$this->form_validation->set_rules('reference_no', lang("reference_no"), 'required');
        $this->form_validation->set_rules('amount-paid', lang("amount"), 'required');
        $this->form_validation->set_rules('paid_by', lang("paid_by"), 'required');
		$this->form_validation->set_rules('date', lang("date"), 'required');
        if ($this->form_validation->run() == true) {
            if ($this->Owner || $this->Admin) {
                $date = $this->erp->fld(trim($this->input->post('date')));
            } else {
                $date = date('Y-m-d H:i:s');
            }
			$loan_ids = $this->input->post('loan_id');
			$paid_amounts = $this->input->post('paid_amount');
			$amount = $this->input->post('amount-paid');
			$extra_rate = $this->input->post('extra_amt');
			$principles = $this->input->post('principle');
			$arr_id = explode("_",$loan_ids);
			$arr_paid = explode("_",$paid_amounts);
			$arr_principle = explode("_",$principles);
			$curr_paid = 0;
			$help = false;
			for($i=0; $i<sizeof($arr_id)-1; $i++){
				$loans = array(
					'paid_date' => $date,
					'id' => $arr_id[$i],
					'reference_no' => $this->input->post('reference_no') ? $this->input->post('reference_no') : $this->site->getReference('sp'),
					'paid_amount' => $amount,
					'paid_by' => $this->input->post('paid_by'),
					'note' => $this->input->post('note'),
					'created_by' => $this->session->userdata('user_id')
				);
				$curr_paid += $arr_principle[$i];
				if($this->sales_model->addPaymentLoan($loans)) {
					$sale_loan = $this->sales_model->getSaleId($arr_id[$i]);
					$help = true;
				}
			}
			if($help) {
				$payments = array(
					'biller_id' => $this->session->userdata('user_id'),
					'date' => $date,
					'sale_id' => $sale_loan->sale_id,
					'reference_no' => $this->input->post('reference_no') ? $this->input->post('reference_no') : $this->site->getReference('sp'),
					'amount' => ($amount+$extra_rate),
					'paid_by' => $this->input->post('paid_by'),
					'created_by' => $this->session->userdata('user_id'),
					'note' => $this->input->post('note'),
					'type' => 'received',
					'extra_paid' => $extra_rate
				);
				$this->sales_model->addLoanPayment($payments);
			}
        } elseif ($this->input->post('add_payment')) {
            $this->session->set_flashdata('error', validation_errors());
            redirect($_SERVER["HTTP_REFERER"]);
        }
		
        if ($this->form_validation->run() == true) {
            $this->session->set_flashdata('message', lang("payment_loan_added"));
            redirect($_SERVER["HTTP_REFERER"]);
        } else {
			$val = array();
			if(isset($_GET['ids']) || isset($_GET['values'])){
				$ids = $_GET['ids'];
				$values = $_GET['values'];
				foreach (array_combine($ids, $values) as $id => $value){
					$val =  array(
						'id' => $id,
						'value' => $value
					);
				}
			}

            $this->data['error'] = (validation_errors() ? validation_errors() : $this->session->flashdata('error'));
			$this->data['values'] = $val;	
            $this->data['loan'] = $this->sales_model->getSingleLoanById($id);
            $this->data['payment_ref'] = ''; //$this->site->getReference('sp');
            $this->data['modal_js'] = $this->site->modal_js();
			$this->data['total_payment'] = $data;
			$this->data['id'] = $id;
			$this->data['paid_amount'] = $paid_amount;
			$this->data['principle'] = $principle;
            $this->load->view($this->theme . 'sales/add_payment_loan', $this->data);
        }
		
    }
	
	function add_installment($id = NULL)
    {
        $this->erp->checkPermissions('payments', true);
        $this->load->helper('security');

        //$this->form_validation->set_rules('reference_no', lang("reference_no"), 'required');
        $this->form_validation->set_rules('amount-paid', lang("amount"), 'required');
        $this->form_validation->set_rules('paid_by', lang("paid_by"), 'required');
		$this->form_validation->set_rules('date', lang("date"), 'required');
        if ($this->form_validation->run() == true) {
            if ($this->Owner || $this->Admin) {
                $date = $this->erp->fld(trim($this->input->post('date')));
            } else {
                $date = date('Y-m-d H:i:s');
            }
			$loan_id = $this->input->post('loan_id');
			$paid_amounts = $this->input->post('paid_amount');
			$amount = $this->input->post('amount-paid');
			$extra_rate = $this->input->post('extra_amt');
			$principles = $this->input->post('principle');
			$interest = $this->input->post('interest');
			$help = false;
			$loans = array(
				'paid_date' => $date,
				'id' => $loan_id,
				'reference_no' => $this->input->post('reference_no') ? $this->input->post('reference_no') : $this->site->getReference('sp'),
				'paid_amount' => $amount,
				'paid_by' => $this->input->post('paid_by'),
				'note' => $this->input->post('note'),
				'created_by' => $this->session->userdata('user_id')
			);
			if($loans) {
				$sale_loan = $this->sales_model->getSaleId($loan_id);
				$payments = array(
					'biller_id' => $this->session->userdata('user_id'),
					'date' => $date,
					'sale_id' => $sale_loan->sale_id,
					'reference_no' => $this->input->post('reference_no') ? $this->input->post('reference_no') : $this->site->getReference('sp'),
					'amount' => ($amount+$extra_rate),
					'interest_paid' => $interest,
					'paid_by' => $this->input->post('paid_by'),
					'created_by' => $this->session->userdata('user_id'),
					'note' => $this->input->post('note'),
					'type' => 'received',
					'extra_paid' => $extra_rate
				);
				//$this->sales_model->addLoanPayment($payments);
			}
        } elseif ($this->input->post('add_payment')) {
            $this->session->set_flashdata('error', validation_errors());
            redirect($_SERVER["HTTP_REFERER"]);
        }
		
        if ($this->form_validation->run() == true && $this->sales_model->addPaymentLoan($loans) && $this->sales_model->addLoanPayment($payments)) {
            $this->session->set_flashdata('message', lang("payment_loan_added"));
            redirect($_SERVER["HTTP_REFERER"]);
        } else {
            $this->data['error'] = (validation_errors() ? validation_errors() : $this->session->flashdata('error'));
			$loan = $this->sales_model->getLoanByID($id);
			$this->data['loan'] = $loan;
            $this->data['reference'] = $this->site->getReference('sp');
            $this->data['modal_js'] = $this->site->modal_js();
			$this->data['total_payment'] = $loan->payment;
			$this->data['id'] = $id;
			$this->data['paid_amount'] = $loan->paid_amount;
			$this->data['principle'] = $loan->principle;
            $this->load->view($this->theme . 'sales/add_installment', $this->data);
        }
		
    }

    /* --------------------------------------------------------------------------------------------- */

    function suggestions()
    {
        $term = $this->input->get('term', TRUE);
        $warehouse_id = $this->input->get('warehouse_id', TRUE);
        $customer_id = $this->input->get('customer_id', TRUE);

        if (strlen($term) < 1 || !$term) {
            die("<script type='text/javascript'>setTimeout(function(){ window.top.location.href = '" . site_url('welcome') . "'; }, 10);</script>");
        }

        $spos = strpos($term, '%');
        if ($spos !== false) {
            $st = explode("%", $term);
            $sr = trim($st[0]);
            $option = trim($st[1]);
        } else {
            $sr = $term;
            $option = '';
        }
        $customer = $this->site->getCompanyByID($customer_id);
        $customer_group = $this->site->getCustomerGroupByID($customer->customer_group_id);
		$user_setting = $this->site->getUserSetting($this->session->userdata('user_id'));
        $rows = $this->sales_model->getProductNames($sr, $warehouse_id, $user_setting->sales_standard, $user_setting->sales_combo, $user_setting->sales_digital, $user_setting->sales_service, $user_setting->sales_category); 
		
        if ($rows) {
            foreach ($rows as $row) {
				
                $option = FALSE;
                //$row->quantity = 0;
                $row->item_tax_method = $row->tax_method;
                $row->qty = 1;
                $row->discount = '0';
                $row->serial = '';
                $options = $this->sales_model->getProductOptions($row->id, $warehouse_id);
				$orderqty = $this->sales_model->getQtyOrder($row->product_id); 
				$group_prices = $this->sales_model->getProductPriceGroup($row->id, $customer->price_group_id);
				$all_group_prices = $this->sales_model->getProductPriceGroup($row->id);
				
				$row->price_id = 0;
				
                if ($options) {
                    $opt = $options[0];
                    if (!$option) {
                        $option = $opt->id;
                    }
                } else {
                    $opt = json_decode('{}');
                    $opt->price = 0;
                }
                $row->option = $option;
                $pis = $this->sales_model->getPurchasedItems($row->id, $warehouse_id, $row->option);
				
                if($pis){
                    foreach ($pis as $pi) {
                        $row->quantity += $pi->quantity_balance;
                    }
                }
				
                if ($options) {
                    $option_quantity = 0;
                    foreach ($options as $option) {
                        $pis = $this->sales_model->getPurchasedItems($row->id, $warehouse_id, $row->option);
                        if($pis){
                            foreach ($pis as $pi) {
                                $option_quantity += $pi->quantity_balance;
                            }
                        }
                        if($option->quantity > $option_quantity) {
                            $option->quantity = $option_quantity;
                        }
                    }
                }
				
                if ($opt->price != 0) {
					if($customer_group->makeup_cost == 1){
						$row->price = $row->cost + (($row->cost * $customer_group->percent) / 100);
					}else{
						$row->price = $opt->price + (($opt->price * $customer_group->percent) / 100);
					}
                } else {
					if($customer_group->makeup_cost == 1){
						$row->price = $row->cost + (($row->cost * $customer_group->percent) / 100);
					}else{
						$row->price = $row->price + (($row->price * $customer_group->percent) / 100);
					}
                }
				
                $row->real_unit_price = $row->price;
                $combo_items = FALSE;
				
                if ($row->tax_rate) {
                    $tax_rate = $this->site->getTaxRateByID($row->tax_rate);
                    if ($row->type == 'combo') {
                        $combo_items = $this->sales_model->getProductComboItems($row->id, $warehouse_id);
                    }
                    $pr[] = array('id' => str_replace(".", "", microtime(true)), 'item_id' => $row->id, 'label' => $row->name . " (" . $row->code . ")" . " (" . $row->price . ")", 'row' => $row, 'combo_items' => $combo_items, 'tax_rate' => $tax_rate, 'options' => $options,'group_prices'=>$group_prices, 'all_group_price' => $all_group_prices,'orderqty'=>$orderqty->quantity);
                } else {
                    $pr[] = array('id' => str_replace(".", "", microtime(true)), 'item_id' => $row->id, 'label' => $row->name . " (" . $row->code . ")" . " (" . $row->price . ")" , 'row' => $row, 'combo_items' => $combo_items, 'tax_rate' => false, 'options' => $options,'group_prices'=>$group_prices, 'all_group_price' => $all_group_prices,'orderqty'=>$orderqty->quantity);
                }
            }
			//$this->erp->print_arrays($pr);
            echo json_encode($pr);
        } else {
            echo json_encode(array(array('id' => 0, 'label' => lang('no_match_found'), 'value' => $term)));
        }
    }
    
    function suggestionsSale()
    {
        $term = $this->input->get('term', TRUE);
		
        $warehouse_id = $this->input->get('warehouse_id', TRUE);
        $customer_id = $this->input->get('customer_id', TRUE);

        if (strlen($term) < 1 || !$term) {
            die("<script type='text/javascript'>setTimeout(function(){ window.top.location.href = '" . site_url('welcome') . "'; }, 10);</script>");
        }

        $spos = strpos($term, '%');
        if ($spos !== false) {
            $st = explode("%", $term);
            $sr = trim($st[0]);
            $option = trim($st[1]);
        } else {
            $sr = $term;
            $option = '';
        }
        $customer = $this->site->getCompanyByID($customer_id);
        $customer_group = $this->site->getCustomerGroupByID($customer->customer_group_id);
		$user_setting = $this->site->getUserSetting($this->session->userdata('user_id'));
		//echo json_encode($group_price);die();
		
			//$rows = $this->sales_model->getProductNamespid($pid, $warehouse_id, $user_setting->sales_standard, $user_setting->sales_combo, $user_setting->sales_digital, $user_setting->sales_service, $user_setting->sales_category);
		
			$rows = $this->sales_model->getProductNames($sr, $warehouse_id, $user_setting->sales_standard, $user_setting->sales_combo, $user_setting->sales_digital, $user_setting->sales_service, $user_setting->sales_category);
	

        if ($rows) {
            foreach ($rows as $row) {
                $option = FALSE;
                $row->quantity = 0;
                $row->item_tax_method = $row->tax_method;
                $row->qty = 1;
                $row->discount = '0';
                $row->serial = '';
                $options = $this->sales_model->getProductOptions($row->id, $warehouse_id);
				
				$group_prices = $this->sales_model->getProductPriceGroup($row->id, $customer->price_group_id);
				$all_group_prices = $this->sales_model->getProductPriceGroup($row->id);
				
				$row->price_id = 0;
				
                if ($options) {
                    $opt = $options[0];
                    if (!$option) {
                        $option = $opt->id;
                    }
                } else {
                    $opt = json_decode('{}');
                    $opt->price = 0;
                }
                $row->option = $option;
                $pis = $this->sales_model->getPurchasedItems($row->id, $warehouse_id, $row->option);
                if($pis){
                    foreach ($pis as $pi) {
                      //  $row->quantity += $pi->quantity_balance;
                    }
                }
				$test = $this->sales_model->getWP2($row->id, $warehouse_id);
				$row->quantity = $test->quantity;
                if ($options) {
                    $option_quantity = 0;
                    foreach ($options as $option) {
                        $pis = $this->sales_model->getPurchasedItems($row->id, $warehouse_id, $row->option);
                        if($pis){
                            foreach ($pis as $pi) {
                                //$option_quantity += $pi->quantity_balance;
                            }
							
                        }
                        if($option->quantity > $option_quantity) {
                         //$option->quantity = $option_quantity; 
                        }
						//$option->quantity = $test->quantity;
                    }
					
                }
				if ($opt->price != 0) {
					if($customer_group->makeup_cost == 1){
						$row->price = $row->cost + (($row->cost * $customer_group->percent) / 100);
					}else{
						$row->price = $opt->price + (($opt->price * $customer_group->percent) / 100);
					}
                } else {
					if($customer_group->makeup_cost == 1){
						$row->price = $row->cost + (($row->cost * $customer_group->percent) / 100);
					}else{
						$row->price = $row->price + (($row->price * $customer_group->percent) / 100);
					}
                }
				
                $row->real_unit_price = $row->price;
                $combo_items = FALSE;
                if ($row->tax_rate) {
                    $tax_rate = $this->site->getTaxRateByID($row->tax_rate);
                    if ($row->type == 'combo') {
                        $combo_items = $this->sales_model->getProductComboItems($row->id, $warehouse_id);
                    }
					$pr[] = array('id' => str_replace(".", "", microtime(true)), 'item_id' => $row->id, 'label' => $row->name . " (" . $row->code . ")", 'row' => $row, 'combo_items' => $combo_items, 'tax_rate' => $tax_rate, 'options' => $options,'group_prices'=>$group_prices, 'all_group_price' => $all_group_prices);
                    
                } else {
                    $pr[] = array('id' => str_replace(".", "", microtime(true)), 'item_id' => $row->id, 'label' => $row->name . " (" . $row->code . ")", 'row' => $row, 'combo_items' => $combo_items, 'tax_rate' => false, 'options' => $options,$options,'group_prices'=>$group_prices, 'all_group_price' => $all_group_prices);
                }
            }
            echo json_encode($pr);
        } else {
            echo json_encode(array(array('id' => 0, 'label' => lang('no_match_found'), 'value' => $term)));
        }
    }

	function suggests()
    {
        $term = $this->input->get('term', TRUE);
        $warehouse_id = $this->input->get('warehouse_id', TRUE);
        $customer_id = $this->input->get('customer_id', TRUE);

        if (strlen($term) < 1 || !$term) {
            die("<script type='text/javascript'>setTimeout(function(){ window.top.location.href = '" . site_url('welcome') . "'; }, 10);</script>");
        }

        $spos = strpos($term, '%');
        if ($spos !== false) {
            $st = explode("%", $term);
            $sr = trim($st[0]);
            $option = trim($st[1]);
        } else {
            $sr = $term;
            $option = '';
        }
        $customer = $this->site->getCompanyByID($customer_id);
        $customer_group = $this->site->getCustomerGroupByID($customer->customer_group_id);
		//$customer_group = $this->site->getMakeupCostByCompanyID($customer_id);
		$user_setting = $this->site->getUserSetting($this->session->userdata('user_id'));
        $rows = $this->sales_model->getProductNumber($sr, $warehouse_id, $user_setting->sales_standard, $user_setting->sales_combo, $user_setting->sales_digital, $user_setting->sales_service, $user_setting->sales_category);
        if ($rows) {
            foreach ($rows as $row) {
                $option = FALSE;
                $row->quantity = 0;
                $row->item_tax_method = $row->tax_method;
                $row->qty = 1;
                $row->discount = '0';
                $row->serial = '';
                $options = $this->sales_model->getProductOptions($row->id, $warehouse_id);
				
				$group_prices = $this->sales_model->getProductPriceGroup($row->id, $customer->price_group_id);
				$all_group_prices = $this->sales_model->getProductPriceGroup($row->id);
				
				$row->price_id = 0;
				
                if ($options) {
                    $opt = $options[0];
                    if (!$option) {
                        $option = $opt->id;
                    }
                } else {
                    $opt = json_decode('{}');
                    $opt->price = 0;
                }
                $row->option = $option;
                $pis = $this->sales_model->getPurchasedItems($row->id, $warehouse_id, $row->option);
                if($pis){
                    foreach ($pis as $pi) {
                        $row->quantity += $pi->quantity_balance;
                    }
                }
                if ($options) {
                    $option_quantity = 0;
                    foreach ($options as $option) {
                        $pis = $this->sales_model->getPurchasedItems($row->id, $warehouse_id, $row->option);
                        if($pis){
                            foreach ($pis as $pi) {
                                $option_quantity += $pi->quantity_balance;
                            }
                        }
                        if($option->quantity > $option_quantity) {
                            $option->quantity = $option_quantity;
                        }
                    }
                }
                if ($opt->price != 0) {
					if($customer_group->makeup_cost == 1){
						$row->price = $row->cost + (($row->cost * $customer_group->percent) / 100);
					}else{
						$row->price = $opt->price + (($opt->price * $customer_group->percent) / 100);
					}
                } else {
					if($customer_group->makeup_cost == 1){
						$row->price = $row->cost + (($row->cost * $customer_group->percent) / 100);
					}else{
						$row->price = $row->price + (($row->price * $customer_group->percent) / 100);
					}
                }
                $row->real_unit_price = $row->price;
                $combo_items = FALSE;
                if ($row->tax_rate) {
                    $tax_rate = $this->site->getTaxRateByID($row->tax_rate);
                    if ($row->type == 'combo') {
                        $combo_items = $this->sales_model->getProductComboItems($row->id, $warehouse_id);
                    }
                    $pr[] = array('id' => str_replace(".", "", microtime(true)), 'item_id' => $row->id, 'label' => $row->name . " (" . $row->code . ")", 'row' => $row, 'combo_items' => $combo_items, 'tax_rate' => $tax_rate, 'options' => $options,'group_prices'=>$group_prices, 'all_group_price' => $all_group_prices);
                } else {
                    $pr[] = array('id' => str_replace(".", "", microtime(true)), 'item_id' => $row->id, 'label' => $row->name . " (" . $row->code . ")", 'row' => $row, 'combo_items' => $combo_items, 'tax_rate' => false, 'options' => $options,'group_prices'=>$group_prices, 'all_group_price' => $all_group_prices);
                }
            }
            echo json_encode($pr);
        } else {
            echo json_encode(array(array('id' => 0, 'label' => lang('no_match_found'), 'value' => $term)));
        }
    }
	/* --------------------------------------------------------------------------------------------- */

    function Pcode()
    {
        $term = $this->input->get('term', TRUE);
        $warehouse_id = $this->input->get('warehouse_id', TRUE);
        $customer_id = $this->input->get('customer_id', TRUE);

        if (strlen($term) < 1 || !$term) {
            die("<script type='text/javascript'>setTimeout(function(){ window.top.location.href = '" . site_url('welcome') . "'; }, 10);</script>");
        }

        $spos = strpos($term, '%');
        if ($spos !== false) {
            $st = explode("%", $term);
            $sr = trim($st[0]);
            $option = trim($st[1]);
        } else {
            $sr = $term;
            $option = '';
        }
        $customer = $this->site->getCompanyByID($customer_id);
        $customer_group = $this->site->getCustomerGroupByID($customer->customer_group_id);
        $rows = $this->sales_model->getProductCodes($sr, $warehouse_id);
        if ($rows) {
            foreach ($rows as $row) {
                $option = FALSE;
                $row->quantity = 0;
                $row->item_tax_method = $row->tax_method;
                $row->qty = 1;
                $row->discount = '0';
                $row->serial = '';
                $options = $this->sales_model->getProductOptions($row->id, $warehouse_id);
                if ($options) {
                    $opt = $options[0];
                    if (!$option) {
                        $option = $opt->id;
                    }
                } else {
                    $opt = json_decode('{}');
                    $opt->price = 0;
                }
                $row->option = $option;
                $pis = $this->sales_model->getPurchasedItems($row->id, $warehouse_id, $row->option);
                if($pis){
                    foreach ($pis as $pi) {
                        $row->quantity += $pi->quantity_balance;
                    }
                }
                if ($options) {
                    $option_quantity = 0;
                    foreach ($options as $option) {
                        $pis = $this->sales_model->getPurchasedItems($row->id, $warehouse_id, $row->option);
                        if($pis){
                            foreach ($pis as $pi) {
                                $option_quantity += $pi->quantity_balance;
                            }
                        }
                        if($option->quantity > $option_quantity) {
                            $option->quantity = $option_quantity;
                        }
                    }
                }
                if ($opt->price != 0) {
                    $row->price = $opt->price + (($opt->price * $customer_group->percent) / 100);
                } else {
                    $row->price = $row->price + (($row->price * $customer_group->percent) / 100);
                }
                $row->real_unit_price = $row->price;
                $combo_items = FALSE;
                if ($row->tax_rate) {
                    $tax_rate = $this->site->getTaxRateByID($row->tax_rate);
                    if ($row->type == 'combo') {
                        $combo_items = $this->sales_model->getProductComboItems($row->id, $warehouse_id);
                    }
                    $pr[] = array('id' => str_replace(".", "", microtime(true)), 'item_id' => $row->id, 'code' => $row->code, 'label' => $row->name, 'cate_id' => $row->cate_name, 'detail' => $row->details, 'tax_rate' => $tax_rate, 'price' => $row->price, 'strap' => $row->strap, 'pic' => $row->image);
                } else {
                    $pr[] = array('id' => str_replace(".", "", microtime(true)), 'item_id' => $row->id, 'code' => $row->code, 'label' => $row->name, 'cate_id' => $row->cate_name, 'detail' => $row->details, 'tax_rate' => false, 'price' => $row->price, 'strap' => $row->strap, 'pic' => $row->image);
                }
            }
            echo json_encode($pr);
        } else {
            echo json_encode(array(array('id' => 0, 'label' => lang('no_match_found'), 'value' => $term, 'no_pro'=>0)));
        }
    }

	function Pname()
    {
		$code = $this->input->get('code', TRUE);
		$category = $this->input->get('category', TRUE);
		$price = $this->input->get('price', TRUE);
        $term = $this->input->get('term', TRUE);
        $warehouse_id = $this->input->get('warehouse_id', TRUE);
        $customer_id = $this->input->get('customer_id', TRUE);

        if (strlen($term) < 1 || !$term) {
            die("<script type='text/javascript'>setTimeout(function(){ window.top.location.href = '" . site_url('welcome') . "'; }, 10);</script>");
        }

        $spos = strpos($term, '%');
        if ($spos !== false) {
            $st = explode("%", $term);
            $sr = trim($st[0]);
            $option = trim($st[1]);
        } else {
            $sr = $term;
            $option = '';
        }
        $customer = $this->site->getCompanyByID($customer_id);
        $customer_group = $this->site->getCustomerGroupByID($customer->customer_group_id);
        $rows = $this->sales_model->getPname($sr, $warehouse_id, $code, $category, $price);
        if ($rows) {
            foreach ($rows as $row) {
                $option = FALSE;
                $row->quantity = 0;
                $row->item_tax_method = $row->tax_method;
                $row->qty = 1;
                $row->discount = '0';
                $row->serial = '';
                $options = $this->sales_model->getProductOptions($row->id, $warehouse_id);
                if ($options) {
                    $opt = $options[0];
                    if (!$option) {
                        $option = $opt->id;
                    }
                } else {
                    $opt = json_decode('{}');
                    $opt->price = 0;
                }
                $row->option = $option;
                $pis = $this->sales_model->getPurchasedItems($row->id, $warehouse_id, $row->option);
                if($pis){
                    foreach ($pis as $pi) {
                        $row->quantity += $pi->quantity_balance;
                    }
                }
                if ($options) {
                    $option_quantity = 0;
                    foreach ($options as $option) {
                        $pis = $this->sales_model->getPurchasedItems($row->id, $warehouse_id, $row->option);
                        if($pis){
                            foreach ($pis as $pi) {
                                $option_quantity += $pi->quantity_balance;
                            }
                        }
                        if($option->quantity > $option_quantity) {
                            $option->quantity = $option_quantity;
                        }
                    }
                }
                if ($opt->price != 0) {
                    $row->price = $opt->price + (($opt->price * $customer_group->percent) / 100);
                } else {
                    $row->price = $row->price + (($row->price * $customer_group->percent) / 100);
                }
                $row->real_unit_price = $row->price;
                $combo_items = FALSE;
                if ($row->tax_rate) {
                    $tax_rate = $this->site->getTaxRateByID($row->tax_rate);
                    if ($row->type == 'combo') {
                        $combo_items = $this->sales_model->getProductComboItems($row->id, $warehouse_id);
                    }
                    $pr[] = array('id' => str_replace(".", "", microtime(true)), 'item_id' => $row->id, 'code' => $row->code, 'label' => $row->name, 'cate_id' => $row->cate_name, 'detail' => $row->details, 'tax_rate' => $tax_rate, 'price' => $row->price, 'strap' => $row->strap, 'pic' => $row->image);
                } else {
                    $pr[] = array('id' => str_replace(".", "", microtime(true)), 'item_id' => $row->id, 'code' => $row->code, 'label' => $row->name, 'cate_id' => $row->cate_name, 'detail' => $row->details, 'tax_rate' => false, 'price' => $row->price, 'strap' => $row->strap, 'pic' => $row->image);
                }
            }
            echo json_encode($pr);
        } else {
            echo json_encode(array(array('id' => 0, 'label' => lang('no_match_found'), 'value' => $term, 'no_pro'=>0)));
        }
    }
	
	function Pdescription()
    {
		$code = $this->input->get('code', TRUE);
		$named = $this->input->get('named', TRUE);
		$category = $this->input->get('category', TRUE);
		$price = $this->input->get('price', TRUE);
        $term = $this->input->get('term', TRUE);
        $warehouse_id = $this->input->get('warehouse_id', TRUE);
        $customer_id = $this->input->get('customer_id', TRUE);

        if (strlen($term) < 1 || !$term) {
            die("<script type='text/javascript'>setTimeout(function(){ window.top.location.href = '" . site_url('welcome') . "'; }, 10);</script>");
        }

        $spos = strpos($term, '%');
        if ($spos !== false) {
            $st = explode("%", $term);
            $sr = trim($st[0]);
            $option = trim($st[1]);
        } else {
            $sr = $term;
            $option = '';
        }
        $customer = $this->site->getCompanyByID($customer_id);
        $customer_group = $this->site->getCustomerGroupByID($customer->customer_group_id);
        $rows = $this->sales_model->getPdescription($sr, $warehouse_id, $named, $code, $price, $category);
        if ($rows) {
            foreach ($rows as $row) {
                $option = FALSE;
                $row->quantity = 0;
                $row->item_tax_method = $row->tax_method;
                $row->qty = 1;
                $row->discount = '0';
                $row->serial = '';
                $options = $this->sales_model->getProductOptions($row->id, $warehouse_id);
                if ($options) {
                    $opt = $options[0];
                    if (!$option) {
                        $option = $opt->id;
                    }
                } else {
                    $opt = json_decode('{}');
                    $opt->price = 0;
                }
                $row->option = $option;
                $pis = $this->sales_model->getPurchasedItems($row->id, $warehouse_id, $row->option);
                if($pis){
                    foreach ($pis as $pi) {
                        $row->quantity += $pi->quantity_balance;
                    }
                }
                if ($options) {
                    $option_quantity = 0;
                    foreach ($options as $option) {
                        $pis = $this->sales_model->getPurchasedItems($row->id, $warehouse_id, $row->option);
                        if($pis){
                            foreach ($pis as $pi) {
                                $option_quantity += $pi->quantity_balance;
                            }
                        }
                        if($option->quantity > $option_quantity) {
                            $option->quantity = $option_quantity;
                        }
                    }
                }
                if ($opt->price != 0) {
                    $row->price = $opt->price + (($opt->price * $customer_group->percent) / 100);
                } else {
                    $row->price = $row->price + (($row->price * $customer_group->percent) / 100);
                }
                $row->real_unit_price = $row->price;
                $combo_items = FALSE;
                if ($row->tax_rate) {
                    $tax_rate = $this->site->getTaxRateByID($row->tax_rate);
                    if ($row->type == 'combo') {
                        $combo_items = $this->sales_model->getProductComboItems($row->id, $warehouse_id);
                    }
                    $pr[] = array('id' => str_replace(".", "", microtime(true)), 'item_id' => $row->id, 'code' => $row->code, 'label' => $row->name, 'cate_id' => $row->cate_name, 'detail' => $row->details, 'tax_rate' => $tax_rate, 'price' => $row->price, 'strap' => $row->strap, 'pic' => $row->image);
                } else {
                    $pr[] = array('id' => str_replace(".", "", microtime(true)), 'item_id' => $row->id, 'code' => $row->code, 'label' => $row->name, 'cate_id' => $row->cate_name, 'detail' => $row->details, 'tax_rate' => false, 'price' => $row->price, 'strap' => $row->strap, 'pic' => $row->image);
                }
            }
            echo json_encode($pr);
        } else {
            echo json_encode(array(array('id' => 0, 'label' => lang('no_match_found'), 'value' => $term, 'no_pro'=>0)));
        }
    }
	
	function Pcategory()
    {
		$code = $this->input->get('code', TRUE);
		$named = $this->input->get('named', TRUE);
		$price = $this->input->get('price', TRUE);
        $term = $this->input->get('term', TRUE);
        $warehouse_id = $this->input->get('warehouse_id', TRUE);
        $customer_id = $this->input->get('customer_id', TRUE);

        if (strlen($term) < 1 || !$term) {
            die("<script type='text/javascript'>setTimeout(function(){ window.top.location.href = '" . site_url('welcome') . "'; }, 10);</script>");
        }

        $spos = strpos($term, '%');
        if ($spos !== false) {
            $st = explode("%", $term);
            $sr = trim($st[0]);
            $option = trim($st[1]);
        } else {
            $sr = $term;
            $option = '';
        }
        $customer = $this->site->getCompanyByID($customer_id);
        $customer_group = $this->site->getCustomerGroupByID($customer->customer_group_id);
        $rows = $this->sales_model->getPcategory($sr, $warehouse_id, $code, $named, $price);
        if ($rows) {
            foreach ($rows as $row) {
                $option = FALSE;
                $row->quantity = 0;
                $row->item_tax_method = $row->tax_method;
                $row->qty = 1;
                $row->discount = '0';
                $row->serial = '';
                $options = $this->sales_model->getProductOptions($row->id, $warehouse_id);
                if ($options) {
                    $opt = $options[0];
                    if (!$option) {
                        $option = $opt->id;
                    }
                } else {
                    $opt = json_decode('{}');
                    $opt->price = 0;
                }
                $row->option = $option;
                $pis = $this->sales_model->getPurchasedItems($row->id, $warehouse_id, $row->option);
                if($pis){
                    foreach ($pis as $pi) {
                        $row->quantity += $pi->quantity_balance;
                    }
                }
                if ($options) {
                    $option_quantity = 0;
                    foreach ($options as $option) {
                        $pis = $this->sales_model->getPurchasedItems($row->id, $warehouse_id, $row->option);
                        if($pis){
                            foreach ($pis as $pi) {
                                $option_quantity += $pi->quantity_balance;
                            }
                        }
                        if($option->quantity > $option_quantity) {
                            $option->quantity = $option_quantity;
                        }
                    }
                }
                if ($opt->price != 0) {
                    $row->price = $opt->price + (($opt->price * $customer_group->percent) / 100);
                } else {
                    $row->price = $row->price + (($row->price * $customer_group->percent) / 100);
                }
                $row->real_unit_price = $row->price;
                $combo_items = FALSE;
                if ($row->tax_rate) {
                    $tax_rate = $this->site->getTaxRateByID($row->tax_rate);
                    if ($row->type == 'combo') {
                        $combo_items = $this->sales_model->getProductComboItems($row->id, $warehouse_id);
                    }
                    $pr[] = array('id' => str_replace(".", "", microtime(true)), 'item_id' => $row->id, 'code' => $row->code, 'label' => $row->name, 'cate_id' => $row->category_id, 'detail' => $row->details, 'tax_rate' => $tax_rate, 'price' => $row->price, 'strap' => $row->strap, 'pic' => $row->image);
                } else {
                    $pr[] = array('id' => str_replace(".", "", microtime(true)), 'item_id' => $row->id, 'code' => $row->code, 'label' => $row->name, 'cate_id' => $row->cate_name, 'detail' => $row->details, 'tax_rate' => false, 'price' => $row->price, 'strap' => $row->strap, 'pic' => $row->image);
                }
            }
            echo json_encode($pr);
        } else {
            echo json_encode(array(array('id' => 0, 'label' => lang('no_match_found'), 'value' => $term, 'no_pro'=>0)));
        }
    }
	
	function Pprice()
    {
		$code = $this->input->get('code', TRUE);
		$name = $this->input->get('name', TRUE);
		$category = $this->input->get('category', TRUE);
        $term = $this->input->get('term', TRUE);
        $warehouse_id = $this->input->get('warehouse_id', TRUE);
        $customer_id = $this->input->get('customer_id', TRUE);

        if (strlen($term) < 1 || !$term) {
            die("<script type='text/javascript'>setTimeout(function(){ window.top.location.href = '" . site_url('welcome') . "'; }, 10);</script>");
        }

        $spos = strpos($term, '%');
        if ($spos !== false) {
            $st = explode("%", $term);
            $sr = trim($st[0]);
            $option = trim($st[1]);
        } else {
            $sr = $term;
            $option = '';
        }
        $customer = $this->site->getCompanyByID($customer_id);
        $customer_group = $this->site->getCustomerGroupByID($customer->customer_group_id);
        $rows = $this->sales_model->getPprice($sr, $warehouse_id, $code, $name, $category);
        if ($rows) {
            foreach ($rows as $row) {
                $option = FALSE;
                $row->quantity = 0;
                $row->item_tax_method = $row->tax_method;
                $row->qty = 1;
                $row->discount = '0';
                $row->serial = '';
                $options = $this->sales_model->getProductOptions($row->id, $warehouse_id);
                if ($options) {
                    $opt = $options[0];
                    if (!$option) {
                        $option = $opt->id;
                    }
                } else {
                    $opt = json_decode('{}');
                    $opt->price = 0;
                }
                $row->option = $option;
                $pis = $this->sales_model->getPurchasedItems($row->id, $warehouse_id, $row->option);
                if($pis){
                    foreach ($pis as $pi) {
                        $row->quantity += $pi->quantity_balance;
                    }
                }
                if ($options) {
                    $option_quantity = 0;
                    foreach ($options as $option) {
                        $pis = $this->sales_model->getPurchasedItems($row->id, $warehouse_id, $row->option);
                        if($pis){
                            foreach ($pis as $pi) {
                                $option_quantity += $pi->quantity_balance;
                            }
                        }
                        if($option->quantity > $option_quantity) {
                            $option->quantity = $option_quantity;
                        }
                    }
                }
                if ($opt->price != 0) {
                    $row->price = $opt->price + (($opt->price * $customer_group->percent) / 100);
                } else {
                    $row->price = $row->price + (($row->price * $customer_group->percent) / 100);
                }
                $row->real_unit_price = $row->price;
                $combo_items = FALSE;
                if ($row->tax_rate) {
                    $tax_rate = $this->site->getTaxRateByID($row->tax_rate);
                    if ($row->type == 'combo') {
                        $combo_items = $this->sales_model->getProductComboItems($row->id, $warehouse_id);
                    }
                    $pr[] = array('id' => str_replace(".", "", microtime(true)), 'item_id' => $row->id, 'code' => $row->code, 'label' => $row->name, 'cate_id' => $row->cate_name, 'detail' => $row->details, 'tax_rate' => $tax_rate, 'price' => $row->price, 'strap' => $row->strap, 'pic' => $row->image);
                } else {
                    $pr[] = array('id' => str_replace(".", "", microtime(true)), 'item_id' => $row->id, 'code' => $row->code, 'label' => $row->name, 'cate_id' => $row->cate_name, 'detail' => $row->details, 'tax_rate' => false, 'price' => $row->price, 'strap' => $row->strap, 'pic' => $row->image);
                }
            }
            echo json_encode($pr);
        } else {
            echo json_encode(array(array('id' => 0, 'label' => lang('no_match_found'), 'value' => $term, 'no_pro'=>0)));
        }
    }
	
	function Pstrap()
    {
        $term = $this->input->get('term', TRUE);
        $warehouse_id = $this->input->get('warehouse_id', TRUE);
        $customer_id = $this->input->get('customer_id', TRUE);

        if (strlen($term) < 1 || !$term) {
            die("<script type='text/javascript'>setTimeout(function(){ window.top.location.href = '" . site_url('welcome') . "'; }, 10);</script>");
        }

        $spos = strpos($term, '%');
        if ($spos !== false) {
            $st = explode("%", $term);
            $sr = trim($st[0]);
            $option = trim($st[1]);
        } else {
            $sr = $term;
            $option = '';
        }
        $customer = $this->site->getCompanyByID($customer_id);
        $customer_group = $this->site->getCustomerGroupByID($customer->customer_group_id);
        $rows = $this->sales_model->getPstrap($sr, $warehouse_id);
        if ($rows) {
            foreach ($rows as $row) {
                $option = FALSE;
                $row->quantity = 0;
                $row->item_tax_method = $row->tax_method;
                $row->qty = 1;
                $row->discount = '0';
                $row->serial = '';
                $options = $this->sales_model->getProductOptions($row->id, $warehouse_id);
                if ($options) {
                    $opt = $options[0];
                    if (!$option) {
                        $option = $opt->id;
                    }
                } else {
                    $opt = json_decode('{}');
                    $opt->price = 0;
                }
                $row->option = $option;
                $pis = $this->sales_model->getPurchasedItems($row->id, $warehouse_id, $row->option);
                if($pis){
                    foreach ($pis as $pi) {
                        $row->quantity += $pi->quantity_balance;
                    }
                }
                if ($options) {
                    $option_quantity = 0;
                    foreach ($options as $option) {
                        $pis = $this->sales_model->getPurchasedItems($row->id, $warehouse_id, $row->option);
                        if($pis){
                            foreach ($pis as $pi) {
                                $option_quantity += $pi->quantity_balance;
                            }
                        }
                        if($option->quantity > $option_quantity) {
                            $option->quantity = $option_quantity;
                        }
                    }
                }
                if ($opt->price != 0) {
                    $row->price = $opt->price + (($opt->price * $customer_group->percent) / 100);
                } else {
                    $row->price = $row->price + (($row->price * $customer_group->percent) / 100);
                }
                $row->real_unit_price = $row->price;
                $combo_items = FALSE;
                if ($row->tax_rate) {
                    $tax_rate = $this->site->getTaxRateByID($row->tax_rate);
                    if ($row->type == 'combo') {
                        $combo_items = $this->sales_model->getProductComboItems($row->id, $warehouse_id);
                    }
                    $pr[] = array('id' => str_replace(".", "", microtime(true)), 'item_id' => $row->id, 'code' => $row->code, 'label' => $row->name, 'cate_id' => $row->cate_name, 'detail' => $row->details, 'tax_rate' => $tax_rate, 'price' => $row->price, 'strap' => $row->strap, 'pic' => $row->image);
                } else {
                    $pr[] = array('id' => str_replace(".", "", microtime(true)), 'item_id' => $row->id, 'code' => $row->code, 'label' => $row->name, 'cate_id' => $row->cate_name, 'detail' => $row->details, 'tax_rate' => false, 'price' => $row->price, 'strap' => $row->strap, 'pic' => $row->image);
                }
            }
            echo json_encode($pr);
        } else {
            echo json_encode(array(array('id' => 0, 'label' => lang('no_match_found'), 'value' => $term)));
        }
    }
	
	function fcode()
    {
        $term = $this->input->get('term', TRUE);

        if (strlen($term) < 1 || !$term) {
            die("<script type='text/javascript'>setTimeout(function(){ window.top.location.href = '" . site_url('welcome') . "'; }, 10);</script>");
        }

        $spos = strpos($term, '%');
        if ($spos !== false) {
            $st = explode("%", $term);
            $sr = trim($st[0]);
            $option = trim($st[1]);
        } else {
            $sr = $term;
            $option = '';
        }
        $rows = $this->sales_model->getfcode($sr);
        if ($rows) {
            foreach ($rows as $row) {
                $pr[] = array('id' => str_replace(".", "", microtime(true)), 'item_id' => $row->id, 'code' => $row->name, 'label' => $row->description, 'floor' => $row->floor, 'status' => $row->status);
            }
            echo json_encode($pr);
        } else {
            echo json_encode(array(array('id' => 0, 'label' => lang('no_match_found'), 'value' => $term)));
        }
    }
	
	function fdescription()
    {
        $term = $this->input->get('term', TRUE);

        if (strlen($term) < 1 || !$term) {
            die("<script type='text/javascript'>setTimeout(function(){ window.top.location.href = '" . site_url('welcome') . "'; }, 10);</script>");
        }

        $spos = strpos($term, '%');
        if ($spos !== false) {
            $st = explode("%", $term);
            $sr = trim($st[0]);
            $option = trim($st[1]);
        } else {
            $sr = $term;
            $option = '';
        }
        $rows = $this->sales_model->getfdescription($sr);
        if ($rows) {
            foreach ($rows as $row) {
                $pr[] = array('id' => str_replace(".", "", microtime(true)), 'item_id' => $row->id, 'code' => $row->name, 'label' => $row->description, 'floor' => $row->floor, 'status' => $row->status);
            }
            echo json_encode($pr);
        } else {
            echo json_encode(array(array('id' => 0, 'label' => lang('no_match_found'), 'value' => $term)));
        }
    }
	
	function ffloor()
    {
        $term = $this->input->get('term', TRUE);
        if (strlen($term) < 1 || !$term) {
            die("<script type='text/javascript'>setTimeout(function(){ window.top.location.href = '" . site_url('welcome') . "'; }, 10);</script>");
        }

        $spos = strpos($term, '%');
        if ($spos !== false) {
            $st = explode("%", $term);
            $sr = trim($st[0]);
            $option = trim($st[1]);
        } else {
            $sr = $term;
            $option = '';
        }
        $rows = $this->sales_model->getffloor($sr);
        if ($rows) {
            foreach ($rows as $row) {
                $pr[] = array('id' => str_replace(".", "", microtime(true)), 'item_id' => $row->id, 'code' => $row->name, 'label' => $row->description, 'floor' => $row->floor, 'status' => $row->status);
            }
            echo json_encode($pr);
        } else {
            echo json_encode(array(array('id' => 0, 'label' => lang('no_match_found'), 'value' => $term)));
        }
    }
    
    function floor_de()
    {
        $term = $this->input->get('term', TRUE);
        if (strlen($term) < 1 || !$term) {
            die("<script type='text/javascript'>setTimeout(function(){ window.top.location.href = '" . site_url('welcome') . "'; }, 10);</script>");
        }

        $spos = strpos($term, '%');
        if ($spos !== false) {
            $st = explode("%", $term);
            $sr = trim($st[0]);
            $option = trim($st[1]);
        } else {
            $sr = $term;
            $option = '';
        }
        $rows = $this->sales_model->getfdescription($sr);
        if ($rows) {
            foreach ($rows as $row) {
                $pr[] = array('id' => str_replace(".", "", microtime(true)), 'item_id' => $row->id, 'code' => $row->name, 'label' => $row->description, 'floor' => $row->floor);
            }
            echo json_encode($pr);
        } else {
            echo json_encode(array(array('id' => 0, 'label' => lang('no_match_found'), 'value' => $term)));
        }
    }
	
	function getfloor()
    {
        $term = $this->input->get('term', TRUE);
        if (strlen($term) < 1 || !$term) {
            die("<script type='text/javascript'>setTimeout(function(){ window.top.location.href = '" . site_url('welcome') . "'; }, 10);</script>");
        }

        $spos = strpos($term, '%');
        if ($spos !== false) {
            $st = explode("%", $term);
            $sr = trim($st[0]);
            $option = trim($st[1]);
        } else {
            $sr = $term;
            $option = '';
        }
        $rows = $this->sales_model->getfloors($sr);
        if ($rows) {
            foreach ($rows as $row) {
                $pr[] = array('id' => str_replace(".", "", microtime(true)), 'item_id' => $row->id, 'code' => $row->name, 'label' => $row->description, 'floor' => $row->floor);
            }
            echo json_encode($pr);
        } else {
            echo json_encode(array(array('id' => 0, 'label' => lang('no_match_found'), 'value' => $term)));
        }
    }    
	
    /* ------------------------------------ Gift Cards ---------------------------------- */

    function gift_cards()
    {
        $this->erp->checkPermissions();

        $this->data['error'] = validation_errors() ? validation_errors() : $this->session->flashdata('error');

        $bc = array(array('link' => base_url(), 'page' => lang('home')), array('link' => site_url('sales'), 'page' => lang('sales')), array('link' => '#', 'page' => lang('gift_cards')));
        $meta = array('page_title' => lang('gift_cards'), 'bc' => $bc);
        $this->page_construct('sales/gift_cards', $meta, $this->data);
    }

    function getGiftCards()
    {

        $this->load->library('datatables');
        $this->datatables
            ->select($this->db->dbprefix('gift_cards') . ".id as id, card_no, value, balance, CONCAT(" . $this->db->dbprefix('users') . ".first_name, ' ', " . $this->db->dbprefix('users') . ".last_name) as created_by, customer, expiry", FALSE)
            ->join('users', 'users.id=gift_cards.created_by', 'left')
            ->from("gift_cards")
            ->add_column("Actions", "<center><a href='" . site_url('sales/view_gift_card_history/$2') . "' class='tip' title='" . lang("view_gift_card_history") . "' data-toggle='modal' data-target='#myModal'><i class=\"fa fa-file-text-o\"></i></a> <a href='" . site_url('sales/view_gift_card/$1') . "' class='tip' title='" . lang("view_gift_card") . "' data-toggle='modal' data-target='#myModal'><i class=\"fa fa-eye\"></i></a> <a href='" . site_url('sales/edit_gift_card/$1') . "' class='tip' title='" . lang("edit_gift_card") . "' data-toggle='modal' data-target='#myModal'><i class=\"fa fa-edit\"></i></a> <a href='#' class='tip po' title='<b>" . lang("delete_gift_card") . "</b>' data-content=\"<p>" . lang('r_u_sure') . "</p><a class='btn btn-danger po-delete' href='" . site_url('sales/delete_gift_card/$1') . "'>" . lang('i_m_sure') . "</a> <button class='btn po-close'>" . lang('no') . "</button>\"  rel='popover'><i class=\"fa fa-trash-o\"></i></a></center>", "id,card_no");
        //->unset_column('id');

        echo $this->datatables->generate();
    }
	
	function getLoans(){
		
        $this->erp->checkPermissions('payments', true);
		
		
        $detail_link = anchor('sales/view/$1', '<i class="fa fa-file-text-o"></i> ' . lang('sale_details'));
        $payments_link = anchor('sales/payments/$1', '<i class="fa fa-money"></i> ' . lang('view_payments'), 'data-toggle="modal" data-target="#myModal"');
        $add_payment_link = anchor('sales/add_payment/$1', '<i class="fa fa-money"></i> ' . lang('add_payment'), 'data-toggle="modal" data-target="#myModal"');
        $email_link = anchor('sales/email/$1', '<i class="fa fa-envelope"></i> ' . lang('email_sale'), 'data-toggle="modal" data-target="#myModal"');
        $edit_link = anchor('sales/edit/$1', '<i class="fa fa-edit"></i> ' . lang('edit_sale'), 'class="sledit"');
        
        $pdf_link = anchor('sales/pdf/$1', '<i class="fa fa-file-pdf-o"></i> ' . lang('download_pdf'));
        $delete_link = "<a href='#' class='loan' title='<b>" . lang("delete_sale") . "</b>' data-content=\"<p>"
					. lang('r_u_sure') . "</p><a class='btn btn-danger po-delete' href='" . site_url('sales/delete_loan/$1') . "'>"
					. lang('i_m_sure') . "</a> <button class='btn po-close'>" . lang('no') . "</button>\"  rel='popover'><i class=\"fa fa-trash-o\"></i> "
					. lang('delete_sale') . "</a>";
		$action = '<div class="text-center"><div class="btn-group text-left">'
            . '<button type="button" class="btn btn-default btn-xs btn-primary dropdown-toggle" data-toggle="dropdown">'
            . lang('actions') . ' <span class="caret"></span></button>
        <ul class="dropdown-menu pull-right" role="menu">
            <li>' . $detail_link . '</li>
            <li>' . $payments_link . '</li>
            <li>' . $add_payment_link . '</li>
            <li>' . $edit_link . '</li>
            <li>' . $pdf_link . '</li>
            <li>' . $email_link . '</li>
        </ul>
    </div></div>';
        //$action = '<div class="text-center">' . $detail_link . ' ' . $edit_link . ' ' . $email_link . ' ' . $delete_link . '</div>';

        $this->load->library('datatables');
		$this->datatables
			->select("erp_loans.id, 
					erp_loans.period,
					erp_loans.dateline,
					erp_sales.reference_no,
					shop.company,
					cust.name,
					(erp_loans.interest + erp_loans.principle) AS amount,
					erp_loans.paid_amount as paid,
					((erp_loans.interest + erp_loans.principle) - erp_loans.paid_amount) as balance,
					IF(erp_loans.paid_amount > 0, 'partial', 'due') as status")
			->from('loans')
			->join('sales', 'sales.id = loans.sale_id', 'INNER')
			->join('companies as erp_shop', 'shop.id = sales.biller_id', 'INNER')
			->join('companies as erp_cust', 'cust.id = sales.customer_id', 'INNER')
			->where('loans.dateline <=', date('Y-m-d'))
			->where('erp_loans.payment > erp_loans.paid_amount')
			->group_by('loans.id');
			if ($this->permission['sales-loan'] = ''){
				if (!$this->Customer && !$this->Supplier && !$this->Owner && !$this->Admin) {
			if(!$this->session->userdata('edit_right') == 0){
				$this->datatables->where('sales.created_by', $this->session->userdata('user_id'));
			}
        } elseif ($this->Customer) {
            $this->datatables->where('customer_id', $this->session->userdata('user_id'));
        }
			}
        
        $this->datatables->add_column("Actions", '<div class="text-center"><div class="btn-group text-left">'  . '<button type="button" class="btn btn-default btn-xs btn-primary dropdown-toggle" data-toggle="dropdown">'. lang('actions') . ' <span class="caret"></span></button><ul class="dropdown-menu pull-right" role="menu"><li>' . $detail_link . '</li><li>' . $payments_link . '</li><li>' . $add_payment_link . '</li><li>' . $edit_link . '</li><li>' . $pdf_link . '</li><li>' . $email_link . '</li><li>' . $delete_link . '</li></ul></div></div>', $this->db->dbprefix('loans').".sale_id");
        echo $this->datatables->generate();
    
	}

    function view_gift_card($id = NULL)
    {
        $this->data['page_title'] =lang('gift_card');
        $gift_card = $this->site->getGiftCardByID($id);
        $this->data['gift_card'] = $this->site->getGiftCardByID($id);
        $this->data['customer'] = $this->site->getCompanyByID($gift_card->customer_id);
        $this->load->view($this->theme . 'sales/view_gift_card', $this->data);
    }
	
	function view_gift_card_history($no = NULL, $start = NULL, $end = NULL)
    {
        if(isset($_POST['start'])){
            $start = $_POST['start'];
        }
		if(isset($_POST['end'])){
            $end = $_POST['end'];
        }
		
		if (!$start) {
            $start = $this->db->escape(date('Y-m') . '-1');
            $start_date = date('Y-m') . '-1';
        } else {
            $start = $this->db->escape(urldecode($start_date));
        }
        if (!$end) {
            $end = $this->db->escape(date('Y-m-d H:i'));
            $end_date = date('Y-m-d H:i');
        } else {
            $end = $this->db->escape(urldecode($end_date));
        }
		
		if(isset($_GET['d']) != ""){
			$date = $_GET['d'];
            $this->data['date'] = $date;
		}

        $data['error'] = (validation_errors() ? validation_errors() : $this->session->flashdata('error'));
		
		$this->data['start'] = urldecode($start_date);
        $this->data['end'] = urldecode($end_date);
		
		$this->data['card_no'] = $no;
		$this->data['page_title'] =lang('gift_card');
        //$gift_card = $this->site->getGiftCardByID($no);
        //$this->data['gift_card'] = $this->site->getGiftCardHistoryByNo($no);
        //$this->data['customer'] = $this->site->getCompanyByID($gift_card->customer_id);
        $this->load->view($this->theme . 'sales/view_gift_card_history', $this->data);
    }
	
	function getGiftCardsHistory()
    {
        if(isset($_GET['start'])){
            $start = $_GET['start'];
        }
		if(isset($_GET['end'])){
            $end = $_GET['end'];
        }
        if(isset($_GET['no'])){
            $no = $_GET['no'];
        }

		$this->load->library('datatables');
        $this->datatables
            ->select($this->db->dbprefix('payments') . ".date as date, card_no,". $this->db->dbprefix('payments') . ".reference_no as payment_ref, " . $this->db->dbprefix('sales') . ".reference_no as sale_ref, amount, type", FALSE)
			->from("payments")
            ->join('sales', 'payments.sale_id=sales.id', 'inner')
			->join('gift_cards', 'gift_cards.card_no=payments.cc_no', 'inner')
			->where($this->db->dbprefix('gift_cards') . '.card_no', $no);
			if (isset($start)) {
				$this->datatables->where($this->db->dbprefix('sales') . '.date', '2016-02-18 15:31:10');
			}
        //->unset_column('id');

        echo $this->datatables->generate();
			
    }
	
	function getMakeupCost($customer_id)
    {
        if ($dp = $this->site->getMakeupCostByCompanyID($customer_id)) {
                echo json_encode($dp);
        } else {
            echo json_encode(false);
        }
    }
	
	function validate_deposit($customer_id)
    {
        //$this->erp->checkPermissions();
        if ($dp = $this->site->getDepositByCompanyID($customer_id)) {
                echo json_encode($dp);
        } else {
            echo json_encode(false);
        }
    }

    function validate_gift_card($no)
    {
        //$this->erp->checkPermissions();
        if ($gc = $this->site->getGiftCardByNO($no)) {
            if ($gc->expiry) {
                if ($gc->expiry >= date('Y-m-d')) {
                    echo json_encode($gc);
                } else {
                    echo json_encode(false);
                }
            } else {
                echo json_encode($gc);
            }
        } else {
            echo json_encode(false);
        }
    }

    function add_gift_card()
    {
        $this->erp->checkPermissions();

        $this->form_validation->set_rules('card_no', lang("card_no"), 'trim|is_unique[gift_cards.card_no]|required');
        $this->form_validation->set_rules('value', lang("value"), 'required');

        if ($this->form_validation->run() == true) {
            $customer_details = $this->input->post('customer') ? $this->site->getCompanyByID($this->input->post('customer')) : NULL;
            $customer = $customer_details ? $customer_details->company : NULL;
            $data = array('card_no' => $this->input->post('card_no'),
                'value' => $this->input->post('value'),
                'customer_id' => $this->input->post('customer') ? $this->input->post('customer') : NULL,
                'customer' => $customer,
                'balance' => $this->input->post('value'),
                'expiry' => $this->input->post('expiry') ? $this->erp->fsd($this->input->post('expiry')) : NULL,
                'created_by' => $this->session->userdata('user_id')
            );
            $sa_data = array();
            $ca_data = array();
            if ($this->input->post('staff_points')) {
                $sa_points = $this->input->post('sa_points');
                $user = $this->site->getUser($this->input->post('user'));
                if ($user->award_points < $sa_points) {
                    $this->session->set_flashdata('error', lang("award_points_wrong"));
                    redirect("sales/gift_cards");
                }
                $sa_data = array('user' => $user->id, 'points' => ($user->award_points - $sa_points));
            } elseif ($customer_details && $this->input->post('use_points')) {
                $ca_points = $this->input->post('ca_points');
                if ($customer_details->award_points < $ca_points) {
                    $this->session->set_flashdata('error', lang("award_points_wrong"));
                    redirect("sales/gift_cards");
                }
                $ca_data = array('customer' => $customer->id, 'points' => ($customer_details->award_points - $ca_points));
            }
        } elseif ($this->input->post('add_gift_card')) {
            $this->session->set_flashdata('error', validation_errors());
            redirect("sales/gift_cards");
        }

        if ($this->form_validation->run() == true && $this->sales_model->addGiftCard($data, $ca_data, $sa_data)) {
            $this->session->set_flashdata('message', lang("gift_card_added"));
            redirect("sales/gift_cards");
        } else {
            $this->data['error'] = (validation_errors() ? validation_errors() : $this->session->flashdata('error'));
            $this->data['modal_js'] = $this->site->modal_js();
            $this->data['users'] = $this->sales_model->getStaff();
            $this->data['page_title'] = lang("new_gift_card");
            $this->load->view($this->theme . 'sales/add_gift_card', $this->data);
        }
    }

    function edit_gift_card($id = NULL)
    {
        $this->erp->checkPermissions(false, true);

        $this->form_validation->set_rules('card_no', lang("card_no"), 'trim|required');
        $gc_details = $this->site->getGiftCardByID($id);
        if ($this->input->post('card_no') != $gc_details->card_no) {
            $this->form_validation->set_rules('card_no', lang("card_no"), 'is_unique[gift_cards.card_no]');
        }
        $this->form_validation->set_rules('value', lang("value"), 'required');
        //$this->form_validation->set_rules('customer', lang("customer"), 'xss_clean');

        if ($this->form_validation->run() == true) {
            $gift_card = $this->site->getGiftCardByID($id);
            $customer_details = $this->input->post('customer') ? $this->site->getCompanyByID($this->input->post('customer')) : NULL;
            $customer = $customer_details ? $customer_details->company : NULL;
            $data = array('card_no' => $this->input->post('card_no'),
                'value' => $this->input->post('value'),
                'customer_id' => $this->input->post('customer') ? $this->input->post('customer') : NULL,
                'customer' => $customer,
                'balance' => ($this->input->post('value') - $gift_card->value) + $gift_card->balance,
                'expiry' => $this->input->post('expiry') ? $this->erp->fsd($this->input->post('expiry')) : NULL,
            );
        } elseif ($this->input->post('edit_gift_card')) {
            $this->session->set_flashdata('error', validation_errors());
            redirect("sales/gift_cards");
        }

        if ($this->form_validation->run() == true && $this->sales_model->updateGiftCard($id, $data)) {
            $this->session->set_flashdata('message', lang("gift_card_updated"));
            redirect("sales/gift_cards");
        } else {
            $this->data['error'] = (validation_errors() ? validation_errors() : $this->session->flashdata('error'));
            $this->data['gift_card'] = $this->site->getGiftCardByID($id);
            $this->data['id'] = $id;
            $this->data['modal_js'] = $this->site->modal_js();
            $this->load->view($this->theme . 'sales/edit_gift_card', $this->data);
        }
    }

    function sell_gift_card()
    {
        $this->erp->checkPermissions('gift_cards', true);
        $error = NULL;
        $gcData = $this->input->get('gcdata');
        if (empty($gcData[0])) {
            $error = lang("value") . " " . lang("is_required");
        }
        if (empty($gcData[1])) {
            $error = lang("card_no") . " " . lang("is_required");
        }


        $customer_details = (!empty($gcData[2])) ? $this->site->getCompanyByID($gcData[2]) : NULL;
        $customer = $customer_details ? $customer_details->company : NULL;
        $data = array('card_no' => $gcData[0],
            'value' => $gcData[1],
            'customer_id' => (!empty($gcData[2])) ? $gcData[2] : NULL,
            'customer' => $customer,
            'balance' => $gcData[1],
            'expiry' => (!empty($gcData[3])) ? $this->erp->fsd($gcData[3]) : NULL,
            'created_by' => $this->session->userdata('user_id')
        );

        if (!$error) {
            if ($this->sales_model->addGiftCard($data)) {
                echo json_encode(array('result' => 'success', 'message' => lang("gift_card_added")));
            }
        } else {
            echo json_encode(array('result' => 'failed', 'message' => $error));
        }

    }

    function delete_gift_card($id = NULL)
    {
        $this->erp->checkPermissions();

        if ($this->sales_model->deleteGiftCard($id)) {
            echo lang("gift_card_deleted");
        }
    }

    function gift_card_actions()
    {
        if (!$this->Owner) {
            $this->session->set_flashdata('warning', lang('access_denied'));
            redirect($_SERVER["HTTP_REFERER"]);
        }

        $this->form_validation->set_rules('form_action', lang("form_action"), 'required');

        if ($this->form_validation->run() == true) {

            if (!empty($_POST['val'])) {
                if ($this->input->post('form_action') == 'delete') {
                    foreach ($_POST['val'] as $id) {
                        $this->sales_model->deleteGiftCard($id);
                    }
                    $this->session->set_flashdata('message', lang("gift_cards_deleted"));
                    redirect($_SERVER["HTTP_REFERER"]);
                }

                if ($this->input->post('form_action') == 'export_excel' || $this->input->post('form_action') == 'export_pdf') {

                    $this->load->library('excel');
                    $this->excel->setActiveSheetIndex(0);
                    $this->excel->getActiveSheet()->setTitle(lang('gift_cards'));
                    $this->excel->getActiveSheet()->SetCellValue('A1', lang('card_no'));
                    $this->excel->getActiveSheet()->SetCellValue('B1', lang('value'));
                    $this->excel->getActiveSheet()->SetCellValue('C1', lang('customer'));

                    $row = 2;
                    foreach ($_POST['val'] as $id) {
                        $sc = $this->site->getGiftCardByID($id);
                        $this->excel->getActiveSheet()->SetCellValue('A' . $row, $sc->card_no);
                        $this->excel->getActiveSheet()->SetCellValue('B' . $row, $sc->value);
                        $this->excel->getActiveSheet()->SetCellValue('C' . $row, $sc->customer);
                        $row++;
                    }

                    $this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
                    $this->excel->getDefaultStyle()->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                    $filename = 'gift_cards_' . date('Y_m_d_H_i_s');
                    if ($this->input->post('form_action') == 'export_pdf') {
                        $styleArray = array('borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN)));
                        $this->excel->getDefaultStyle()->applyFromArray($styleArray);
                        $this->excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
                        require_once(APPPATH . "third_party" . DIRECTORY_SEPARATOR . "MPDF" . DIRECTORY_SEPARATOR . "mpdf.php");
                        $rendererName = PHPExcel_Settings::PDF_RENDERER_MPDF;
                        $rendererLibrary = 'MPDF';
                        $rendererLibraryPath = APPPATH . 'third_party' . DIRECTORY_SEPARATOR . $rendererLibrary;
                        if (!PHPExcel_Settings::setPdfRenderer($rendererName, $rendererLibraryPath)) {
                            die('Please set the $rendererName: ' . $rendererName . ' and $rendererLibraryPath: ' . $rendererLibraryPath . ' values' .
                                PHP_EOL . ' as appropriate for your directory structure');
                        }

                        header('Content-Type: application/pdf');
                        header('Content-Disposition: attachment;filename="' . $filename . '.pdf"');
                        header('Cache-Control: max-age=0');

                        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'PDF');
                        return $objWriter->save('php://output');
                    }
                    if ($this->input->post('form_action') == 'export_excel') {
                        header('Content-Type: application/vnd.ms-excel');
                        header('Content-Disposition: attachment;filename="' . $filename . '.xls"');
                        header('Cache-Control: max-age=0');

                        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
                        return $objWriter->save('php://output');
                    }

                    redirect($_SERVER["HTTP_REFERER"]);
                }
            } else {
                $this->session->set_flashdata('error', lang("no_gift_card_selected"));
                redirect($_SERVER["HTTP_REFERER"]);
            }
        } else {
            $this->session->set_flashdata('error', validation_errors());
            redirect($_SERVER["HTTP_REFERER"]);
        }
    }

    function get_award_points($id = NULL)
    {
        $this->erp->checkPermissions('index');

        $row = $this->site->getUser($id);
        echo json_encode(array('sa_points' => $row->award_points));
    }

    function customer_opening_balance()
    {
        $this->erp->checkPermissions('opening_ar', null, 'sales');
        $this->load->helper('security');
        $this->load->library('erp');

        $this->form_validation->set_rules('userfile', lang("upload_file"), 'xss_clean');
        if ($this->form_validation->run() == true) {

            if (isset($_FILES["userfile"]))
            {
                    $this->load->library('upload');
                    $config['upload_path'] = 'assets/uploads/csv/';
                    $config['allowed_types'] = 'csv';
                    $config['max_size'] = '2000';
                    $config['overwrite'] = TRUE;
                    $this->upload->initialize($config);
                    if (!$this->upload->do_upload('userfile'))
                    {
                        $error = $this->upload->display_errors();
                        $this->session->set_flashdata('error', $error);
                        redirect("sales/customer_opening_balance");
                    }
                    $csv = $this->upload->file_name;
                    $arrResult = array();
                    $handle = fopen("assets/uploads/csv/" . $csv, "r");
                    if ($handle) {
                        while (($row = fgetcsv($handle,",")) !== FALSE) {
                            $arrResult[] = $row;
                        }
                        fclose($handle);
                    }
                    $titles = array_shift($arrResult);
                    $keys = array('customer_no','customer_name', 'invoice_reference', 'opening_date','invoice_date', 'shop_id','term','sale_id', 'balance', 'deposit');
                    $final = array();
                    foreach ($arrResult as $key => $value) {
                        $final[] = array_combine($keys, $value);
                    }
                    $data_deposit = array();
                    $data_insert = array();
                    $data_payment = array();
					$deposit_gl = array();
					$balance_gl = array();

                    $customer_num = 0;
                    $payments = 0;

                    foreach ($final as $key => $value)
                    {
                         $date = strtr($value['opening_date'], '/', '-');
                            $date = date('Y-m-d H:m:i', strtotime($date));
                         // statement no need model
						 $biller = $this->db->get_where('companies', array('id' => $value['shop_id']))->row();
                         $customer = $this->db->where('company_id',$value['customer_no'])->get('deposits');
                         $customer_num = $customer->num_rows();
					

                         // if biller id not found error.
                         if(count($biller) <= 0)
                         {
                            $this->session->set_flashdata('error', lang('company_error_mismatch_with_database'));
                            redirect("sales/customer_opening_balance");
                         }

                         // if biller not customer type
                         if($biller->group_name != 'biller')
                         {
                            $this->session->set_flashdata('error', lang('company_id_is_not_customer_type'));
                            redirect("sales/customer_opening_balance");
                         }


                         /*if($customer_num > 0)
                         {
                            // deposits updated
                            $amount = $customer->row()->amount;
                            $deposit = $amount + $value['deposit'];
                            $data_deposit[]  = array(
                                                'company_id'    =>  $value['customer_no'],
                                                'updated_by'    =>  $this->session->userdata()['user_id'],
                                                'updated_at'    =>  date('Y-m-d h:i:s'),
                                                'amount'        =>  $deposit,
                                                );
                         }
                         else
                         {*/
							 if($value['deposit'] > 0){
								 // deposit insert
								$data_deposit[]  = array(
									'reference'     => $value['invoice_reference'],
									'company_id'    => $value['customer_no'],
									'amount'        => $value['deposit'],
									'paid_by'       => 'cash',
									'created_by'    => $this->session->userdata()['user_id'],
									'biller_id'     => $value['shop_id'],
                                );
							 }
                         //}
						 // account deposit
						 $deposit = $this->db->select('*')
															->from('account_settings')
															->join('gl_charts','gl_charts.accountcode = default_sale_deposit','inner')
															->join('gl_sections','gl_sections.sectionid = gl_charts.sectionid','inner')
															->get()->row();
						// account opening balance
						$balance = $this->db->select('*')
															->from('account_settings')
															->join('gl_charts','gl_charts.accountcode = default_open_balance','inner')
															->join('gl_sections','gl_sections.sectionid = gl_charts.sectionid','inner')
															->get()->row();
						// data deposit
						$deposit_gl[] = array(
												'tran_type'=>'DEPOSITS',
												'tran_no'=>0,
												'tran_date'=>date('Y-m-d h:i:s'),
												'sectionid'=>$deposit->sectionid,
												'account_code'=>$deposit->accountcode,
												'narrative'=>$deposit->accountname,
												'amount'=> -$value['deposit'],
												'reference_no'=>$value['invoice_reference'],
												'invoice_ref'=>NULL,
												'ref_type'=>NULL,
												'description'=>$value['customer_name'],
												'biller_id'=>$biller->id,
												'created_by'=>$this->session->userdata()['user_id'],
												'updated_by'=>NULL,
												'bank'=>1,
												'gov_tax'=>0,
												'reference_gov_tax'=>NULL,
											);

						$balance_gl[] = array(
											'tran_type'=>'DEPOSITS',
											'tran_no'=>0,
											'tran_date'=>date('Y-m-d h:i:s'),
											'sectionid'=>$balance->sectionid,
											'account_code'=>$balance->accountcode,
											'narrative'=>$balance->accountname,
											'amount'=> $value['deposit'],
											'reference_no'=>$value['invoice_reference'],
											'invoice_ref'=>NULL,
											'ref_type'=>NULL,
											'description'=>$value['customer_name'],
											'biller_id'=>$biller->id,
											'created_by'=>$this->session->userdata()['user_id'],
											'updated_by'=>NULL,
											'bank'=>1,
											'gov_tax'=>0,
											'reference_gov_tax'=>NULL,
										);

						 // sale insert
						 $data_insert[] = array(
							'reference_no'  =>  $value['invoice_reference'],
							'customer_id'   =>  $value['customer_no'],
                            'date'          =>  $date,
							'biller'        =>  $biller->name,
							'biller_id'     =>  $biller->id,
							'warehouse_id'  =>  0,
							'opening_ar'    =>  2,
							'customer'      =>  $value['customer_name'],
							'total'         =>  $value['balance'],
							'grand_total'   =>  $value['balance'],
							'sale_status'   =>  'completed',
							'payment_status'=>  'due',
							'payment_term'  =>  $value['term'],
							'created_by'    =>  $this->session->userdata()['user_id'],
							'saleman_by'    =>  $value['sale_id'],
							'sale_type'     =>  1,
						);
                    }

                    /*if($customer_num > 0)
                    {
                        $this->db->update_batch('deposits',$data_deposit,'company_id');
	
                    }
                    else
                    {*/
						if($data_deposit){
							$this->db->insert_batch('deposits',$data_deposit);
						}
                    //}

					if($data_deposit){
						$this->db->insert_batch('gl_trans',$deposit_gl);
						$this->db->insert_batch('gl_trans',$balance_gl);
					}

                    $insert = $this->db->insert_batch('sales',$data_insert);
                    if($insert)
                    {
                        $this->session->set_flashdata('message', $this->lang->line("customer_opening_balance_added"));
                        redirect("sales/customer_opening_balance");
                    }
            }
        }
        $bc = array(array('link' => base_url(), 'page' => lang('home')), array('link' => site_url('sales'), 'page' => lang('sales')), array('link' => '#', 'page' => lang('customer_opening_balance')));
        $meta = array('page_title' => lang('customer_opening_balance'), 'bc' => $bc);
        $this->page_construct('sales/customer_opening_balance', $meta, $this->data);
    }
    /* -------------------------------------------------------------------------------------- */

    function sale_by_csv()
    {
        $this->erp->checkPermissions('csv');
        $this->load->helper('security');
        $this->form_validation->set_rules('userfile', $this->lang->line("upload_file"), 'xss_clean');
        $this->form_validation->set_message('is_natural_no_zero', lang("no_zero_required"));

        if ($this->form_validation->run() == true) {
            $quantity = "quantity";
            $product = "product";
            $unit_cost = "unit_cost";
            $tax_rate = "tax_rate";

            $total = 0;
            $product_tax = 0;
            $order_tax = 0;
            $product_discount = 0;
            $order_discount = 0;
            $percentage = '%';

            if (isset($_FILES["userfile"])) {

                $this->load->library('upload');

                $config['upload_path'] = $this->digital_upload_path;
                $config['allowed_types'] = 'csv';
                $config['max_size'] = $this->allowed_file_size;
                $config['overwrite'] = TRUE;

                $this->upload->initialize($config);

                if (!$this->upload->do_upload()) {
                    $error = $this->upload->display_errors();
                    $this->session->set_flashdata('error', $error);
                    redirect("sales/sale_by_csv");
                }
                $csv = $this->upload->file_name;
                $arrResult = array();
                $handle = fopen($this->digital_upload_path . $csv, "r");
                if ($handle) {
                    while (($row = fgetcsv($handle, 1000, ",")) !== FALSE) {
                        $arrResult[] = $row;
                    }
                    fclose($handle);
                }
                $titles = array_shift($arrResult);

                //$keys = array('code', 'net_unit_price', 'quantity', 'variant', 'item_tax_rate', 'discount', 'serial');
                $keys = array('code', 'net_unit_price', 'quantity', 'customer', 'warehouse_code' ,'reference_no', 'date', 'biller_id', 'sale_status', 'payment_term', 'payment_status', 'shipping', 'order_discount', 'order_tax');
                $final = array();
                foreach ($arrResult as $key => $value) {
                    $final[] = array_combine($keys, $value);
                }
                $rw = 2;
                $bak_ref = '';
                $old_reference = '';
				$temp_reference = '';
				$products = array();
				$data = array();
				
				foreach ($final as $csv_pr) {
					$old_reference = $csv_pr['reference_no'];
					if($old_reference != $temp_reference) {
						
						$help = true;
						if($temp_data) {
							foreach($temp_data as $tmp_data) {
								if($tmp_data['reference_no'] == $csv_pr['reference_no']) {
									$help = false;
								}
							}
						}
						
						$temp_data[] = array(
										'reference_no' => $csv_pr['reference_no']
									   );
						
						if($help) {
							foreach($final as $product) {
								if($product['reference_no'] == $csv_pr['reference_no']) { 
									if (!empty($product['code']) && !empty($product['net_unit_price']) && !empty($product['quantity'])) {
										if ($product_details = $this->site->getProductByCode(trim($product['code']))) {
											$item_id = $product_details->id;
											$item_type = $product_details->type;
											$item_code = $product_details->code;
											$item_name = $product_details->name;
											$item_net_price = $product['net_unit_price'];
											$item_quantity = $product['quantity'];
											$item_tax_rate = $product['item_tax_rate'];
											$item_discount = $product['discount'];
											$warehouse = $this->site->getWarehouseByCode(trim($csv_pr['warehouse_code']));
											$warehouse_id = $warehouse->id;
											if (isset($item_code) && isset($item_net_price) && isset($item_quantity)) { 
												$product_details = $this->sales_model->getProductByCode($item_code);
												if (isset($item_discount)) {
													$discount = $item_discount;
													$dpos = strpos($discount, $percentage);
													if ($dpos !== false) {
														$pds = explode("%", $discount);
														$pr_discount = (($this->erp->formatDecimal($item_net_price)) * (Float)($pds[0])) / 100;
													} else {
														$pr_discount = $this->erp->formatDecimal($discount);
													}
												} else {
													$pr_discount = 0;
												}
												$item_net_price = $this->erp->formatDecimal($item_net_price - $pr_discount);
												$pr_item_discount = $this->erp->formatDecimal($pr_discount * $item_quantity);
												$product_discount += $pr_item_discount;
												
												if (isset($item_tax_rate) && $item_tax_rate != 0) {

													if($tax_details = $this->sales_model->getTaxRateByName($item_tax_rate)) {
														$pr_tax = $tax_details->id;
														if ($tax_details->type == 1) {

															$item_tax = $this->erp->formatDecimal((($item_net_price) * $tax_details->rate) / 100);
															$tax = $tax_details->rate . "%";

														} elseif ($tax_details->type == 2) {
															$item_tax = $this->erp->formatDecimal($tax_details->rate);
															$tax = $tax_details->rate;
														}
														$pr_item_tax = $this->erp->formatDecimal($item_tax * $item_quantity);
													} else {
														$this->session->set_flashdata('error', lang("tax_not_found") . " ( " . $item_tax_rate . " ). " . lang("line_no") . " " . $rw);
														redirect($_SERVER["HTTP_REFERER"]);
													}
												} elseif ($product_details->tax_rate) {
													$pr_tax = $product_details->tax_rate;
													$tax_details = $this->site->getTaxRateByID($pr_tax);
													if ($tax_details->type == 1) {
														$item_tax = $this->erp->formatDecimal((($item_net_price) * $tax_details->rate) / 100);
														$tax = $tax_details->rate . "%";
													} elseif ($tax_details->type == 2) {

														$item_tax = $this->erp->formatDecimal($tax_details->rate);
														$tax = $tax_details->rate;

													}
													$pr_item_tax = $this->erp->formatDecimal($item_tax * $item_quantity);

												} else {
													$item_tax = 0;
													$pr_tax = 0;
													$pr_item_tax = 0;
													$tax = "";
												}
												$product_tax += $pr_item_tax;
												
												$subtotal = (($item_net_price * $item_quantity) + $pr_item_tax);
												$products[] = array(
													'product_id' => $item_id,
													'product_code' => $item_code,
													'product_name' => $item_name,
													'product_type' => $item_type,
													'net_unit_price' => $item_net_price,
													'unit_price' => $this->erp->formatDecimal($item_net_price + $item_tax),
													'quantity' => $item_quantity,
													'item_tax' => $pr_item_tax,
													'tax_rate_id' => $pr_tax,
													'tax' => $tax,
													'discount' => $item_discount,
													'item_discount' => $pr_item_discount,
													'subtotal' => $this->erp->formatDecimal($subtotal),
													'real_unit_price' => $this->erp->formatDecimal($item_net_price + $item_tax + $pr_discount),
													'warehouse_id' => $warehouse_id
												);
												$total += $item_net_price * $item_quantity;
											}
										}
									} else {
										$this->session->set_flashdata('error', $this->lang->line("pr_not_found") . " ( " . $product['code'] . " ). " . $this->lang->line("line_no") . " " . $rw);
										redirect($_SERVER["HTTP_REFERER"]);
									}
								}
							}
							
							$date = strtr($csv_pr['date'], '/', '-');
							$date = date('Y-m-d h:m:i', strtotime($date));
							$reference = $csv_pr['reference_no'];
							$sale_status = $csv_pr['sale_status'];
							$payment_term = $csv_pr['payment_term'];
							$payment_status = $csv_pr['payment_status'];
							$shipping = $csv_pr['shipping'];
							$order_discount = $csv_pr['order_discount'];
							$opening_ar = 0;

							$bak_ref = $csv_pr['reference_no'];

							$customer_id = $csv_pr['customer'];
							$biller_id = $csv_pr['biller_id'];
							$customer_details = $this->site->getCustomerNameByID($customer_id);
							$customer = $customer_details->company ? $customer_details->company : $customer_details->name;
							$biller_details = $this->site->getBillerNameByID($biller_id);
							$biller = $biller_details->company != '-' ? $biller_details->company : $biller_details->name;
								
							if ($order_discount) {
								$order_discount_id = $order_discount;
								$opos = strpos($order_discount_id, $percentage);
								if ($opos !== false) {
									$ods = explode("%", $order_discount_id);
									$order_discount = $this->erp->formatDecimal((($total + $product_tax) * (Float)($ods[0])) / 100);
								} else {
									$order_discount = $this->erp->formatDecimal($order_discount_id);
								}
							} else {
								$order_discount_id = NULL;
							}
							$total_discount = $this->erp->formatDecimal($order_discount + $product_discount);

							if ($this->Settings->tax2) {
								$order_tax_id = $this->input->post('order_tax');
								if ($order_tax_details = $this->site->getTaxRateByID($order_tax_id)) {
									if ($order_tax_details->type == 2) {
										$order_tax = $this->erp->formatDecimal($order_tax_details->rate);
									}
									if ($order_tax_details->type == 1) {
										$order_tax = $this->erp->formatDecimal((($total + $product_tax - $order_discount) * $order_tax_details->rate) / 100);
									}
								}
							} else {
								$order_tax_id = NULL;
							}

							$total_tax = $this->erp->formatDecimal($product_tax + $order_tax);
							$grand_total = $this->erp->formatDecimal($this->erp->formatDecimal($total) + $total_tax + $this->erp->formatDecimal($shipping) - $order_discount);
							$data = array('date' => $date,
								'reference_no' => $reference?$reference:$this->site->getReference('so'),
								'customer_id' => $customer_id,
								'customer' => $customer,
								'biller_id' => $biller_id,
								'biller' => $biller,
								'note' => $note,
								'staff_note' => $staff_note,
								'total' => $this->erp->formatDecimal($total),
								'product_discount' => $this->erp->formatDecimal($product_discount),
								'order_discount_id' => $order_discount_id,
								'order_discount' => $order_discount,
								'warehouse_id' => $warehouse_id,
								'total_discount' => $total_discount,
								'product_tax' => $this->erp->formatDecimal($product_tax),
								'order_tax_id' => $order_tax_id,
								'order_tax' => $order_tax,
								'total_tax' => $total_tax,
								'shipping' => $this->erp->formatDecimal($shipping),
								'grand_total' => $grand_total,
								'total_items' => $total_items,
								'sale_status' => $sale_status,
								'payment_status' => $payment_status,
								'payment_term' => $payment_term,
								'due_date' => $due_date,
								'paid' => 0,
								'created_by' => $this->session->userdata('user_id'),
								'opening_ar' => $opening_ar
							);
	
							if ($_FILES['document']['size'] > 0) {
								$this->load->library('upload');
								$config['upload_path'] = $this->digital_upload_path;
								$config['allowed_types'] = $this->digital_file_types;
								$config['max_size'] = $this->allowed_file_size;
								$config['overwrite'] = FALSE;
								$config['encrypt_name'] = TRUE;
								$this->upload->initialize($config);
								if (!$this->upload->do_upload('document')) {
									$error = $this->upload->display_errors();
									$this->session->set_flashdata('error', $error);
									redirect($_SERVER["HTTP_REFERER"]);
								}
								$photo = $this->upload->file_name;
								$data['attachment'] = $photo;
							}
							//$this->erp->print_arrays($data, $products);
							$this->sales_model->addSaleImport($data, $products);
							$this->site->updateReference('so');
							unset($products);
							$products = array();
						}
					}
					$temp_reference = $old_reference;
				}
            }
        }
        
        if ($this->form_validation->run() == true) {
            $this->session->set_userdata('remove_slls', 1);
            $this->session->set_flashdata('message', $this->lang->line("sale_added"));
            redirect("sales");
        } else {
            $data['error'] = (validation_errors() ? validation_errors() : $this->session->flashdata('error'));
            $this->data['warehouses'] = $this->site->getAllWarehouses();
            $this->data['tax_rates'] = $this->site->getAllTaxRates();
            $this->data['billers'] = $this->site->getAllCompanies('biller');
            $this->data['slnumber'] = $this->site->getReference('so');

            $bc = array(array('link' => base_url(), 'page' => lang('home')), array('link' => site_url('sales'), 'page' => lang('sales')), array('link' => '#', 'page' => lang('add_sale_by_csv')));
            $meta = array('page_title' => lang('add_sale_by_csv'), 'bc' => $bc);
            $this->page_construct('sales/sale_by_csv', $meta, $this->data);
        }
    }
	
    /**********suspend**********/
    function suspends_calendar($warehouse_id = NULL){ 
        $this->load->model('reports_model');
        $this->data['warehouse_id'] = $warehouse_id;
        $this->data['users'] = $this->reports_model->getStaff();
        $this->data['warehouses'] = $this->site->getAllWarehouses();
        $this->data['billers'] = $this->site->getAllCompanies('biller');
        $this->data['error'] = validation_errors() ? validation_errors() : $this->session->flashdata('error');
        $bc = array(array('link' => base_url(), 'page' => lang('home')), array('link' => site_url('sales'), 'page' => lang('sales')), array('link' => '#', 'page' => lang('suspend_calendar')));
        $meta = array('page_title' => lang('suspend_calendar'), 'bc' => $bc);
        $this->page_construct('sales/suspends_calendar', $meta, $this->data);
    }

    function getSuspends_calendar()
    {
        $this->erp->checkPermissions('index');

        $this->load->library('datatables');

        //$detail_link = anchor('sales/view/$1', '<i class="fa fa-file-text-o"></i> ' . lang('Room_details'));
        $payments_link = anchor('customers/view/$1', '<i class="fa fa-money"></i> ' . lang('customer_details'), 'data-toggle="modal" data-target="#myModal"');
        //$add_payment_link = anchor('sales/add_payment/$1', '<i class="fa fa-money"></i> ' . lang('Document'), 'data-toggle="modal" data-target="#myModal"');
        
        /*
        $this->datatables
            ->select("(SELECT id FROM erp_suspended_bills sb WHERE sb.suspend_id = erp_suspended.id ) as id,floor,name,description, (SELECT date FROM erp_suspended_bills sb WHERE sb.suspend_id = erp_suspended.id ) as start_date, (SELECT end_date FROM erp_suspended_bills sb WHERE sb.suspend_id = erp_suspended.id ) as end_date, CASE WHEN status = 0 THEN 'Free' WHEN status = 1 THEN 'Booking' ELSE 'Busy' END AS status, (SELECT attachment FROM erp_suspended_bills sb LEFT JOIN erp_companies c ON c.id = sb.customer_id WHERE sb.suspend_id = erp_suspended.id ) as attachment")
            ->from("erp_suspended")
            */
        
        /*$this->datatables
            ->select("(SELECT MAX(id) FROM erp_suspended_bills sb WHERE sb.suspend_id = erp_suspended.id ) as id,floor,name,description, (SELECT MAX(customer) FROM erp_suspended_bills sb WHERE sb.suspend_id = erp_suspended.id ) as customer_name, (SELECT MAX(date) FROM erp_suspended_bills sb WHERE sb.suspend_id = erp_suspended.id ) as start_date, (SELECT MAX(end_date) FROM erp_suspended_bills sb WHERE sb.suspend_id = erp_suspended.id ) as end_date, CASE WHEN status = 0 THEN 'free' WHEN status = 1 THEN 'busy' ELSE 'busy' END AS status, (SELECT MAX(attachment) FROM erp_suspended_bills sb LEFT JOIN erp_companies c ON c.id = sb.customer_id WHERE sb.suspend_id = erp_suspended.id ) as attachment")
            ->from("erp_suspended")
            ->where('(SELECT date FROM erp_suspended_bills sb WHERE sb.suspend_id = erp_suspended.id ) IS NOT NULL', null, false)
            ->where('(SELECT end_date FROM erp_suspended_bills sb WHERE sb.suspend_id = erp_suspended.id ) IS NOT NULL', null, false)*/
		$this->datatables
            ->select("erp_suspended.id as id,floor,erp_suspended.name, (CASE WHEN erp_suspended.note != '' THEN erp_suspended.note ELSE (SELECT MAX(customer) FROM erp_suspended_bills sb WHERE sb.suspend_id = erp_suspended.id ) END) as customer_name, (SELECT total FROM erp_suspended_bills WHERE erp_suspended_bills.suspend_id = erp_suspended.id) as price, (SELECT deposit_amount FROM erp_companies WHERE erp_companies.id = erp_suspended_bills.customer_id) as deposite, description, erp_companies.start_date as start_date, erp_companies.end_date as end_date, (12 * (YEAR (erp_companies.end_date) - YEAR (erp_companies.start_date)) + (MONTH (erp_companies.end_date) - MONTH (erp_companies.start_date))) as term_year, CASE WHEN erp_suspended.status = 0 THEN 'free' WHEN erp_suspended.status = 1 THEN 'busy' WHEN erp_suspended.status = 2 THEN 'book' ELSE 'busy' END AS status, (SELECT MAX(attachment) FROM erp_suspended_bills sb LEFT JOIN erp_companies c ON c.id = sb.customer_id WHERE sb.suspend_id = erp_suspended.id ) as attachment")
			->join('erp_suspended_bills', 'erp_suspended.id = erp_suspended_bills.suspend_id', 'left')
			->join('erp_companies', 'erp_companies.id = erp_suspended_bills.customer_id', 'left')
            ->from("erp_suspended")
            //->where('(SELECT date FROM erp_suspended_bills sb WHERE sb.suspend_id = erp_suspended.id ) IS NOT NULL', null, false)
            //->where('(SELECT end_date FROM erp_suspended_bills sb WHERE sb.suspend_id = erp_suspended.id ) IS NOT NULL', null, false)
            ->add_column("Actions", '<center>
                    <div class="btn-group text-left">'
            . '<button type="button" class="btn btn-default btn-xs btn-primary dropdown-toggle" data-toggle="dropdown">'
            . lang('actions') . ' <span class="caret"></span></button>
        <ul class="dropdown-menu pull-right" role="menu">
            <li>' . $payments_link . '</li>
        </ul>
		</div>
                    </center>', "id");
        echo $this->datatables->generate();
    }
	
	function suppend_actions()
    {
        if (!$this->Owner) {
            $this->session->set_flashdata('warning', lang('access_denied'));
            redirect($_SERVER["HTTP_REFERER"]);
        }

        $this->form_validation->set_rules('form_action', lang("form_action"), 'required');

        if ($this->form_validation->run() == true) {

            if (!empty($_POST['val'])) {
                if ($this->input->post('form_action') == 'delete') {
					
                    $error = false;
                    foreach ($_POST['val'] as $id) {
                        if (!$this->settings_model->deleteSuppend($id)) {
                            $error = true;
                        }
                    }
                    if ($error) {
                        $this->session->set_flashdata('warning', lang('suppliers_x_deleted_have_purchases'));
                    } else {
                        $this->session->set_flashdata('message', $this->lang->line("account_deleted_successfully"));
                    }
                    redirect($_SERVER["HTTP_REFERER"]);
                }

                if ($this->input->post('form_action') == 'export_excel' || $this->input->post('form_action') == 'export_pdf') {

                    $this->load->library('excel');
                    $this->excel->setActiveSheetIndex(0);
                    $this->excel->getActiveSheet()->setTitle(lang('suspend'));
                    $this->excel->getActiveSheet()->SetCellValue('A1', lang('floor'));
                    $this->excel->getActiveSheet()->SetCellValue('B1', lang('room|table name'));
					$this->excel->getActiveSheet()->SetCellValue('C1', lang('price'));
					$this->excel->getActiveSheet()->SetCellValue('D1', lang('deposite'));
                    $this->excel->getActiveSheet()->SetCellValue('E1', lang('description'));
                    $this->excel->getActiveSheet()->SetCellValue('F1', lang('customer_name'));
                    $this->excel->getActiveSheet()->SetCellValue('G1', lang('date'));
                    $this->excel->getActiveSheet()->SetCellValue('H1', lang('end_date'));
					$this->excel->getActiveSheet()->SetCellValue('I1', lang('term_of_rents_months'));
                    $this->excel->getActiveSheet()->SetCellValue('J1', lang('status'));

                    $row = 2;
                    foreach ($_POST['val'] as $id) {
                        $suspend = $this->site->getSuspendByID($id);
                        $this->excel->getActiveSheet()->SetCellValue('A' . $row, $suspend->floor);
                        $this->excel->getActiveSheet()->SetCellValue('B' . $row, $suspend->room_name);
						$this->excel->getActiveSheet()->SetCellValue('C' . $row, $suspend->price);
						$this->excel->getActiveSheet()->SetCellValue('D' . $row, $suspend->deposite);
                        $this->excel->getActiveSheet()->SetCellValue('E' . $row, $suspend->description);
                        $this->excel->getActiveSheet()->SetCellValue('F' . $row, $suspend->customer_name);
                        $this->excel->getActiveSheet()->SetCellValue('G' . $row, $suspend->start_date);
                        $this->excel->getActiveSheet()->SetCellValue('H' . $row, $suspend->end_date);
						$this->excel->getActiveSheet()->SetCellValue('I' . $row, $suspend->term_year);
                        $this->excel->getActiveSheet()->SetCellValue('J' . $row, $suspend->status);
                        $row++;
                    }

                    $this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(20);
                    $this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
                    $this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
                    $this->excel->getDefaultStyle()->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                    $filename = 'suspend_' . date('Y_m_d_H_i_s');
                    if ($this->input->post('form_action') == 'export_pdf') {
                        $styleArray = array('borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN)));
                        $this->excel->getDefaultStyle()->applyFromArray($styleArray);
                        $this->excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
                        require_once(APPPATH . "third_party" . DIRECTORY_SEPARATOR . "MPDF" . DIRECTORY_SEPARATOR . "mpdf.php");
                        $rendererName = PHPExcel_Settings::PDF_RENDERER_MPDF;
                        $rendererLibrary = 'MPDF';
                        $rendererLibraryPath = APPPATH . 'third_party' . DIRECTORY_SEPARATOR . $rendererLibrary;
                        if (!PHPExcel_Settings::setPdfRenderer($rendererName, $rendererLibraryPath)) {
                            die('Please set the $rendererName: ' . $rendererName . ' and $rendererLibraryPath: ' . $rendererLibraryPath . ' values' .
                                PHP_EOL . ' as appropriate for your directory structure');
                        }

                        header('Content-Type: application/pdf');
                        header('Content-Disposition: attachment;filename="' . $filename . '.pdf"');
                        header('Cache-Control: max-age=0');

                        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'PDF');
                        return $objWriter->save('php://output');
                    }
                    if ($this->input->post('form_action') == 'export_excel') {
                        header('Content-Type: application/vnd.ms-excel');
                        header('Content-Disposition: attachment;filename="' . $filename . '.xls"');
                        header('Cache-Control: max-age=0');

                        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
                        return $objWriter->save('php://output');
                    }

                    redirect($_SERVER["HTTP_REFERER"]);
                }
            } else {
                $this->session->set_flashdata('error', $this->lang->line("no_supplier_selected"));
                redirect($_SERVER["HTTP_REFERER"]);
            }
        } else {
            $this->session->set_flashdata('error', validation_errors());
            redirect($_SERVER["HTTP_REFERER"]);
        }
    } 
	
	function listSaleRoom_actions()
    {
        if (!$this->Owner) {
            $this->session->set_flashdata('warning', lang('access_denied'));
            redirect($_SERVER["HTTP_REFERER"]);
        }

        $this->form_validation->set_rules('form_action', lang("form_action"), 'required');

        if ($this->form_validation->run() == true) {
            if (!empty($_POST['val'])) {
                if ($this->input->post('form_action') == 'delete') {
                    foreach ($_POST['val'] as $id) {
                        $this->sales_model->deleteSuspend($id);
                    }
                    $this->session->set_flashdata('message', lang("sales_deleted"));
                    redirect($_SERVER["HTTP_REFERER"]);
                }

                if ($this->input->post('form_action') == 'export_excel' || $this->input->post('form_action') == 'export_pdf') {

                    $this->load->library('excel');
                    $this->excel->setActiveSheetIndex(0);
                    $this->excel->getActiveSheet()->setTitle(lang('sales'));
                    $this->excel->getActiveSheet()->SetCellValue('A1', lang('date'));
                    $this->excel->getActiveSheet()->SetCellValue('B1', lang('suspend'));
                    $this->excel->getActiveSheet()->SetCellValue('C1', lang('shop'));
                    $this->excel->getActiveSheet()->SetCellValue('D1', lang('customer'));
					$this->excel->getActiveSheet()->SetCellValue('E1', lang('sale_status'));
                    $this->excel->getActiveSheet()->SetCellValue('F1', lang('grand_total'));
                    $this->excel->getActiveSheet()->SetCellValue('G1', lang('paid'));
                    $this->excel->getActiveSheet()->SetCellValue('H1', lang('balance'));
					$this->excel->getActiveSheet()->SetCellValue('I1', lang('payment_status'));

                    $row = 2;
                    foreach ($_POST['val'] as $id) {
                        $sale = $this->sales_model->getSuspendByID($id);
                        $this->excel->getActiveSheet()->SetCellValue('A' . $row, $this->erp->hrld($sale->date));
                        $this->excel->getActiveSheet()->SetCellValue('B' . $row, $sale->suspend);
                        $this->excel->getActiveSheet()->SetCellValue('C' . $row, $sale->biller);
                        $this->excel->getActiveSheet()->SetCellValue('D' . $row, $sale->customer);
                        $this->excel->getActiveSheet()->SetCellValue('E' . $row, $sale->sale_status);
                        $this->excel->getActiveSheet()->SetCellValue('F' . $row, $sale->grand_total);
                        $this->excel->getActiveSheet()->SetCellValue('G' . $row, $sale->paid);
						$this->excel->getActiveSheet()->SetCellValue('H' . $row, $sale->balance);
                        $this->excel->getActiveSheet()->SetCellValue('I' . $row, $sale->payment_status);
                        $row++;
                    }

                    $this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(20);
                    $this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
                    $this->excel->getDefaultStyle()->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                    $filename = 'list_sales_room_' . date('Y_m_d_H_i_s');
                    if ($this->input->post('form_action') == 'export_pdf') {
                        $styleArray = array('borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN)));
                        $this->excel->getDefaultStyle()->applyFromArray($styleArray);
                        $this->excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
                        require_once(APPPATH . "third_party" . DIRECTORY_SEPARATOR . "MPDF" . DIRECTORY_SEPARATOR . "mpdf.php");
                        $rendererName = PHPExcel_Settings::PDF_RENDERER_MPDF;
                        $rendererLibrary = 'MPDF';
                        $rendererLibraryPath = APPPATH . 'third_party' . DIRECTORY_SEPARATOR . $rendererLibrary;
                        if (!PHPExcel_Settings::setPdfRenderer($rendererName, $rendererLibraryPath)) {
                            die('Please set the $rendererName: ' . $rendererName . ' and $rendererLibraryPath: ' . $rendererLibraryPath . ' values' .
                                PHP_EOL . ' as appropriate for your directory structure');
                        }

                        header('Content-Type: application/pdf');
                        header('Content-Disposition: attachment;filename="' . $filename . '.pdf"');
                        header('Cache-Control: max-age=0');

                        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'PDF');
                        return $objWriter->save('php://output');
                    }
                    if ($this->input->post('form_action') == 'export_excel') {
                        header('Content-Type: application/vnd.ms-excel');
                        header('Content-Disposition: attachment;filename="' . $filename . '.xls"');
                        header('Cache-Control: max-age=0');

                        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
                        return $objWriter->save('php://output');
                    }

                    redirect($_SERVER["HTTP_REFERER"]);
                }
            } else {
                $this->session->set_flashdata('error', lang("no_sale_selected"));
                redirect($_SERVER["HTTP_REFERER"]);
            }
        } else {
            $this->session->set_flashdata('error', validation_errors());
            redirect($_SERVER["HTTP_REFERER"]);
        }
    } 
	
	function show_attachments($id){
		$this->data['file'] = $id;
		$this->load->view($this->theme . 'sales/show_attachment', $this->data);
	}

    function view_room_report($room_id = NULL, $year = NULL, $month = NULL, $pdf = NULL, $cal = 0)
    {

        $q_suspend = $this->db->query('SELECT * FROM erp_suspended_bills WHERE id = ? ', array($room_id))->row();

        $q_suspend_bill = $this->db->query('SELECT * FROM erp_suspended_bills WHERE id = ? ', array($room_id))->result();
        $total_ = 0;
        foreach($q_suspend_bill as $rows)
        {
            $total_ += $rows->total;
        }

        $this->data['total_']           = $total_;
        $this->data['room']             = $q_suspend->suspend_name;
        $this->data['suspended_bills']  = $q_suspend_bill;
        $this->data['error']            = validation_errors() ? validation_errors() : $this->session->flashdata('error');
        
        $bc = array(array('link' => base_url(), 'page' => lang('home')), array('link' => site_url('reports'), 'page' => lang('reports')), array('link' => '#', 'page' => lang('View_Room_Report')));
        $meta = array('page_title' => lang('view_report'), 'bc' => $bc);
        $this->page_construct('reports/view_room_report', $meta, $this->data);
    }

    /**********suspend**********/
    function suspend($warehouse_id = NULL){	
		$this->load->model('reports_model');
		$this->data['warehouse_id'] = $warehouse_id;
		$this->data['users'] = $this->reports_model->getStaff();
        $this->data['warehouses'] = $this->site->getAllWarehouses();
        $this->data['billers'] = $this->site->getAllCompanies('biller');
        $this->data['error'] = validation_errors() ? validation_errors() : $this->session->flashdata('error');
        $bc = array(array('link' => base_url(), 'page' => lang('home')), array('link' => site_url('sales'), 'page' => lang('sales')), array('link' => '#', 'page' => lang('list_sales_suspend')));
        $meta = array('page_title' => lang('list_sales_suspend'), 'bc' => $bc);
        $this->page_construct('sales/suspends', $meta, $this->data);
	}
	
	function getSuspend($warehouse_id = NULL){
		
        $this->erp->checkPermissions('index');	
		
		if ($this->input->get('user')) {
            $user_query = $this->input->get('user');
        } else {
            $user_query = NULL;
        }
        if ($this->input->get('reference_no')) {
            $reference_no = $this->input->get('reference_no');
        } else {
            $reference_no = NULL;
        }
        if ($this->input->get('customer')) {
            $customer = $this->input->get('customer');
        } else {
            $customer = NULL;
        }
        if ($this->input->get('biller')) {
            $biller = $this->input->get('biller');
        } else {
            $biller = NULL;
        }
		if ($this->input->get('warehouse')) {
            $warehouse = $this->input->get('warehouse');
        } else {
            $warehouse = NULL;
        }
        if ($this->input->get('start_date')) {
            $start_date = $this->input->get('start_date');
        } else {
            $start_date = NULL;
        }
        if ($this->input->get('end_date')) {
            $end_date = $this->input->get('end_date');
        } else {
            $end_date = NULL;
        }
        if ($start_date) {
            $start_date = $this->erp->fld($start_date);
            $end_date = $this->erp->fld($end_date);
        }

        if ((! $this->Owner || ! $this->Admin) && ! $warehouse_id) {
            $user = $this->site->getUser();
            $warehouse_id = $user->warehouse_id;
        }
		
        $add_payment_link = anchor('pos/index/$1', '<i class="fa fa-money"></i> ' . lang('add_payment'), '');      
        $action = '<div class="text-center"><div class="btn-group text-left">'
            . '<button type="button" class="btn btn-default btn-xs btn-primary dropdown-toggle" data-toggle="dropdown">'
            . lang('actions') . ' <span class="caret"></span></button>
	        <ul class="dropdown-menu pull-right" role="menu">            
	            <li>' . $add_payment_link . '</li>
	        </ul>
	    </div></div>';       

        $this->load->library('datatables');
		if($warehouse_id){
			$this->datatables
                ->select($this->db->dbprefix('suspended_bills').".id as idd,".$this->db->dbprefix('sales').".date, ".$this->db->dbprefix('sales').".suspend_note as suspend, (select company from ".$this->db->dbprefix('companies')." where id= ".$this->db->dbprefix('sales').".biller_id) as biller,".$this->db->dbprefix('sales').".customer, 
            	case when DATE(".$this->db->dbprefix('suspended_bills').".date)+ INTERVAL (SELECT show_suspend_bar-1 from ".$this->db->dbprefix('pos_settings')." where ".$this->db->dbprefix('pos_settings').".default_biller=".$this->db->dbprefix('suspended_bills').".biller_id) DAY <= DATE(SYSDATE()) then 'completed' else 'pending' end AS sale_status,
            	".$this->db->dbprefix('sales').".grand_total as grand_total, ".$this->db->dbprefix('sales').".paid as paid, (CASE WHEN ".$this->db->dbprefix('sales').".paid IS NULL THEN ".$this->db->dbprefix('sales').".grand_total ELSE ".$this->db->dbprefix('sales').".grand_total - ".$this->db->dbprefix('sales').".paid END) as balance, CASE WHEN ".$this->db->dbprefix('sales').".paid = 0 THEN 'pending' WHEN ".$this->db->dbprefix('sales').".grand_total = ".$this->db->dbprefix('sales').".paid THEN 'completed' WHEN ".$this->db->dbprefix('sales').".grand_total > ".$this->db->dbprefix('sales').".paid THEN 'partial' ELSE 'pending' END as payment_status")
				->join($this->db->dbprefix('sales'), $this->db->dbprefix('sales').'.suspend_note = '.$this->db->dbprefix('suspended_bills').'.suspend_name', 'left')
                ->from('suspended_bills')
				->where($this->db->dbprefix('sales').'.warehouse_id', $warehouse_id)
				->where('sales.suspend_note !=', " ");
		}else{
			$this->datatables
                ->select($this->db->dbprefix('suspended_bills').".id as idd,".$this->db->dbprefix('sales').".date, ".$this->db->dbprefix('sales').".suspend_note as suspend, (select company from ".$this->db->dbprefix('companies')." where id= ".$this->db->dbprefix('sales').".biller_id) as biller,".$this->db->dbprefix('sales').".customer, 
            	case when DATE(".$this->db->dbprefix('suspended_bills').".date)+ INTERVAL (SELECT show_suspend_bar-1 from ".$this->db->dbprefix('pos_settings')." where ".$this->db->dbprefix('pos_settings').".default_biller=".$this->db->dbprefix('suspended_bills').".biller_id) DAY <= DATE(SYSDATE()) then 'completed' else 'pending' end AS sale_status,
            	".$this->db->dbprefix('sales').".grand_total as grand_total, ".$this->db->dbprefix('sales').".paid as paid, (CASE WHEN ".$this->db->dbprefix('sales').".paid IS NULL THEN ".$this->db->dbprefix('sales').".grand_total ELSE ".$this->db->dbprefix('sales').".grand_total - ".$this->db->dbprefix('sales').".paid END) as balance, CASE WHEN ".$this->db->dbprefix('sales').".paid = 0 THEN 'pending' WHEN ".$this->db->dbprefix('sales').".grand_total = ".$this->db->dbprefix('sales').".paid THEN 'completed' WHEN ".$this->db->dbprefix('sales').".grand_total > ".$this->db->dbprefix('sales').".paid THEN 'partial' ELSE 'pending' END as payment_status")
				->join($this->db->dbprefix('sales'), $this->db->dbprefix('sales').'.suspend_note = '.$this->db->dbprefix('suspended_bills').'.suspend_name', 'left')
				->where('sales.suspend_note !=', " ")
                ->from('suspended_bills');
		}		
		if (!$this->Customer && !$this->Supplier && !$this->Owner && !$this->Admin) {
            $this->datatables->where('created_by', $this->session->userdata('user_id'));
        } elseif ($this->Customer) {
            $this->datatables->where('customer_id', $this->session->userdata('user_id'));
        }
		
		if ($user_query) {
			$this->datatables->where('suspended_bills.created_by', $user_query);
		}
		if ($reference_no) {
			$this->datatables->where('suspended_bills.suspend_name', $reference_no);
		}
		if ($biller) {
			$this->datatables->where('suspended_bills.biller_id', $biller);
		}
		if ($customer) {
			$this->datatables->where('suspended_bills.customer_id', $customer);
		}
		if ($warehouse) {
			$this->datatables->where('suspended_bills.warehouse_id', $warehouse);
		}

		if ($start_date || $end_date) {
			$this->datatables->where($this->db->dbprefix('sales').'.date >= "' . $start_date . '" AND ' . $this->db->dbprefix('sales').'.date < "' . $end_date . '"');
		}

        $this->datatables->add_column("Actions", $action, "idd");
        echo $this->datatables->generate();  
	}
	
	function modal_view_suspend($id = NULL)
    {
        $this->erp->checkPermissions('index', TRUE);

        if ($this->input->get('id')) {
            $id = $this->input->get('id');
        }
		$this->load->model('pos_model');
		$this->data['pos'] = $this->pos_model->getSetting();
        $this->data['error'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('error');
        $inv = $this->sales_model->getInvoiceByID($id);
		//$susin = $this->sales_model->getInvoiceByIDs($id);
		$susin = $this->sales_model->getInvoiceBySuspendIDs($id);
        if(isset($susin)){
            foreach($susin as $test){
				
            }
        }
		//$this->erp->print_arrays($susin);
        $this->erp->view_rights($inv->created_by, TRUE);
        
        //$detail= $this->sales_model->getAllSuspendDetail($id);
		$detail= $this->sales_model->getAllSuspendBySupendID($id);
        
        $this->data['customer'] = $this->site->getCompanyByID($detail->customer_id);
        $this->data['biller'] = $this->site->getCompanyByID($detail->biller_id);
        $this->data['created_by'] = $this->site->getUser($detail->created_by);
        $this->data['updated_by'] = $inv->updated_by ? $this->site->getUser($inv->updated_by) : NULL;
        $this->data['warehouse'] = $this->site->getWarehouseByID($detail->warehouse_id);
        $this->data['inv'] = $inv;
		$this->data['susin'] = $test;
        $this->data['detail'] =$detail; 
        $this->data['suspend'] = $this->sales_model->getAllRoomDetail($detail->suspend_id);
        $return = $this->sales_model->getReturnBySID($id);
        $this->data['return_sale'] = $return;
        $this->data['rows'] = $this->sales_model->getAllsuspendItem($id);

        $this->load->view($this->theme.'sales/suspend_modal_view', $this->data);
    }
    
    /***********suspend end*********/
	
	/*************Book**************/
	function modal_book($id = NULL)
    {
		if ($this->input->get('id')) {
			$id = $this->input->get('id');
		}
		$this->data['id'] = $id;
        $this->erp->checkPermissions('index', TRUE);
		$this->form_validation->set_rules('start_date', lang("start_date"), 'required');
		if ($this->form_validation->run() == true) {
			if($this->input->post('start_date')){
				$start_date = $this->erp->fld($this->input->post('start_date'));
			}else{
				$start_date = '';
			}
			if($this->input->post('end_date')){
				$end_date   = $this->erp->fld($this->input->post('end_date'));
			}else{
				$end_date   = '';
			}
			$SQLdata = array(
				'status'    => 2,
				'startdate' => $start_date,
				'enddate'   => $end_date,
				'customer_id' => $this->input->post('customer'),
				'note'      => $this->input->post('note')
			);
			//$this->erp->print_arrays($SQLdata);
			$room = $this->input->post('room_id');
			$this->sales_model->add_booking($room, $SQLdata);
			$this->session->set_flashdata('message', lang("suspend_booked"));
			redirect('sales/suspends_calendar');
		}else{
			$this->data['modal_js'] = $this->site->modal_js();
			$this->data['pos']      = $this->sales_model->getSetting();
			$this->load->view($this->theme.'sales/modal_book', $this->data);
		}
    }
	/*************Book**************/
	
	/**********suspend**********/
    function customers_alerts($warehouse_id = NULL){	
		$this->load->model('reports_model');
		$this->data['warehouse_id'] = $warehouse_id;
		$this->data['users'] = $this->reports_model->getStaff();
        $this->data['warehouses'] = $this->site->getAllWarehouses();
        $this->data['billers'] = $this->site->getAllCompanies('biller');
        $this->data['error'] = validation_errors() ? validation_errors() : $this->session->flashdata('error');
        $bc = array(array('link' => base_url(), 'page' => lang('home')), array('link' => site_url('sales'), 'page' => lang('sales')), array('link' => '#', 'page' => lang('list_customers_alerts')));
        $meta = array('page_title' => lang('list_customers_alerts'), 'bc' => $bc);
        $this->page_construct('sales/customers_alerts', $meta, $this->data);
	}
	
	function getCustomersAlerts($warehouse_id = NULL){
		
        $this->erp->checkPermissions('index');	

        if ($this->input->get('customer')) {
            $customer = $this->input->get('customer');
        } else {
            $customer = NULL;
        }
        if ($this->input->get('start_date')) {
            $start_date = $this->input->get('start_date');
        } else {
            $start_date = NULL;
        }
        if ($this->input->get('end_date')) {
            $end_date = $this->input->get('end_date');
        } else {
            $end_date = NULL;
        }
        if ($start_date) {
            $start_date = $this->erp->fld($start_date);
            $end_date = $this->erp->fld($end_date);
        }

        if ((! $this->Owner || ! $this->Admin) && ! $warehouse_id) {
            $user = $this->site->getUser();
            $warehouse_id = $user->warehouse_id;
        }
		
        $add_payment_link = anchor('pos/index/$1', '<i class="fa fa-money"></i> ' . lang('add_payment'), '');      
        $action = '<div class="text-center"><div class="btn-group text-left">'
            . '<button type="button" class="btn btn-default btn-xs btn-primary dropdown-toggle" data-toggle="dropdown">'
            . lang('actions') . ' <span class="caret"></span></button>
	        <ul class="dropdown-menu pull-right" role="menu">            
	            <li>' . $add_payment_link . '</li>
	        </ul>
	    </div></div>';

        $this->load->library('datatables');

			$this->datatables
					->select("id, id AS cus_no, name, gender, phone, email, address, end_date, COALESCE((SELECT paid FROM erp_sales WHERE customer_id = erp_companies.id  ORDER BY erp_sales.id DESC LIMIT 1 ), 0) AS balance")
					->from('companies');
					$this->datatables->where('CURDATE() >= DATE_SUB(end_date , INTERVAL (SELECT alert_day FROM ' . $this->db->dbprefix('settings').') DAY)');

		if ($customer) {
			$this->datatables->where('companies.id', $customer);
		}
		if ($start_date || $end_date) {
			$this->datatables->where($this->db->dbprefix('companies').'.start_date >= "' . $start_date . '" AND ' . $this->db->dbprefix('companies').'.end_date < "' . $end_date . '"');
		}

        $this->datatables->add_column("Actions", $action, "id");
        echo $this->datatables->generate();  
	}
    
	//------------------- Sale export as Excel and pdf -----------------------
	function getSalesAll($pdf = NULL, $excel = NULL)
    {
		if($pdf || $excel){
			$this->erp->checkPermissions('pdf', 'sales');
		}else{
			$this->erp->checkPermissions('sales');
		}

        $sales = $this->input->get('sales') ? $this->input->get('sales') : NULL;

        if ($pdf || $excel) {

            $this->db
                ->select($this->db->dbprefix('sales') . ".date as dates, " . $this->db->dbprefix('sales') . ".reference_no as reference_nos,". $this->db->dbprefix('sales') .".biller as billers,
				" . $this->db->dbprefix('sales') . ".customer as customers, " . $this->db->dbprefix('sales') . ".sale_status as sale_statuses, 
				" . $this->db->dbprefix('sales') . ".grand_total as grand_totals, " . $this->db->dbprefix('sales') . ".paid as paids,
				(" . $this->db->dbprefix('sales') . ". grand_total - paid) as balances,
				" . $this->db->dbprefix('sales') . ".payment_status as payment_statuses");
				//" . $this->db->dbprefix('warehouses') . ".name as wname");
            $this->db->from('sales');
            //$this->db->join('categories', 'categories.id=products.category_id', 'left');
            //$this->db->join('warehouses', 'warehouses.id=products.warehouse', 'left');
            $this->db->group_by("sales.id")->order_by('sales.date desc');
			$this->db->where('sales.reference_no NOT LIKE "SALE/POS%"');
            if ($sales) {
                $this->db->where('sales.id', $sales);
            }

            $q = $this->db->get();
            if ($q->num_rows() > 0) {
                foreach (($q->result()) as $row) {
                    $data[] = $row;
                }
            } else {
                $data = NULL;
            }

            if (!empty($data)) {

                $this->load->library('excel');
                $this->excel->setActiveSheetIndex(0);
                $this->excel->getActiveSheet()->setTitle(lang('Sales List'));
				$this->excel->getActiveSheet()->SetCellValue('A1', lang('date'));
                $this->excel->getActiveSheet()->SetCellValue('B1', lang('reference_no'));
                $this->excel->getActiveSheet()->SetCellValue('C1', lang('biller'));
                $this->excel->getActiveSheet()->SetCellValue('D1', lang('customer'));
                $this->excel->getActiveSheet()->SetCellValue('E1', lang('sale_status'));
                $this->excel->getActiveSheet()->SetCellValue('F1', lang('grand_total'));
                $this->excel->getActiveSheet()->SetCellValue('G1', lang('paid'));
                $this->excel->getActiveSheet()->SetCellValue('H1', lang('balance'));
				$this->excel->getActiveSheet()->SetCellValue('I1', lang('payment_status'));

                $row = 2;
				
                foreach ($data as $data_row) {
                    //$this->excel->getActiveSheet()->SetCellValue('A' . $row, $this->erp->hrld($data_row->id));
                    $this->excel->getActiveSheet()->SetCellValue('A' . $row, $data_row->dates);
					$this->excel->getActiveSheet()->SetCellValue('B' . $row, $data_row->reference_nos);
                    $this->excel->getActiveSheet()->SetCellValue('C' . $row, $data_row->billers);
                    $this->excel->getActiveSheet()->SetCellValue('D' . $row, $data_row->customers);
                    $this->excel->getActiveSheet()->SetCellValue('E' . $row, $data_row->sale_statuses);
                    $this->excel->getActiveSheet()->SetCellValue('F' . $row, lang($data_row->grand_totals));
					$this->excel->getActiveSheet()->SetCellValue('G' . $row, lang($data_row->paids));
					$this->excel->getActiveSheet()->SetCellValue('H' . $row, lang($data_row->balances));
					$this->excel->getActiveSheet()->SetCellValue('I' . $row, lang($data_row->payment_statuses));
                    //$this->excel->getActiveSheet()->SetCellValue('G' . $row, $data_row->wh);
                    $row++;
                }

                $this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(20);
                $this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
                $this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
                $this->excel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
                $this->excel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
                $this->excel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
                $this->excel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
				$this->excel->getActiveSheet()->getColumnDimension('H')->setWidth(20);
                $filename = lang('Sales List');
                $this->excel->getDefaultStyle()->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                if ($pdf) {
                    $styleArray = array(
                        'borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN))
                    );
                    $this->excel->getDefaultStyle()->applyFromArray($styleArray);
                    $this->excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
                    require_once(APPPATH . "third_party" . DIRECTORY_SEPARATOR . "MPDF" . DIRECTORY_SEPARATOR . "mpdf.php");
                    $rendererName = PHPExcel_Settings::PDF_RENDERER_MPDF;
                    $rendererLibrary = 'MPDF';
                    $rendererLibraryPath = APPPATH . 'third_party' . DIRECTORY_SEPARATOR . $rendererLibrary;
                    if (!PHPExcel_Settings::setPdfRenderer($rendererName, $rendererLibraryPath)) {
                        die('Please set the $rendererName: ' . $rendererName . ' and $rendererLibraryPath: ' . $rendererLibraryPath . ' values' .
                            PHP_EOL . ' as appropriate for your directory structure');
                    }

                    header('Content-Type: application/pdf');
                    header('Content-Disposition: attachment;filename="' . $filename . '.pdf"');
                    header('Cache-Control: max-age=0');

                    $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'PDF');
                    $objWriter->save('php://output');
                    exit();
                }
                if ($excel) {
                    ob_clean();
                    header('Content-Type: application/vnd.ms-excel');
                    header('Content-Disposition: attachment;filename="' . $filename . '.xls"');
                    header('Cache-Control: max-age=0');
                    ob_clean();
                    $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
                    $objWriter->save('php://output');
                    exit();
                }

            }

            $this->session->set_flashdata('error', lang('nothing_found'));
            redirect($_SERVER["HTTP_REFERER"]);

        }
    }
	//-------------------End Sale export -------------------------------------
	
	//-------------------Loan export as Excel and PDF-------------------------
	function getLoansAll($pdf = NULL, $excel = NULL)
    {
        $this->erp->checkPermissions('Sales');

        $sales = $this->input->get('sales') ? $this->input->get('sales') : NULL;

        if ($pdf || $excel) {

			/*
			$this->datatables
			->select($this->db->dbprefix('loans').".reference_no, sales.date, sales.reference_no as ref_no, sales.biller, sales.customer, sales.sale_status, 
			".$this->db->dbprefix('sales').".grand_total, sales.paid, (".$this->db->dbprefix('sales').".grand_total- ".$this->db->dbprefix('sales').".paid) as balance, sales.payment_status")
			->from('sales')
			->join('loans','sales.id=loans.reference_no','INNER')
			->group_by('loans.reference_no');
			*/
		
            $this->db
                ->select($this->db->dbprefix('sales') . ".date as dates, " . $this->db->dbprefix('sales') . ".reference_no as reference_nos,". $this->db->dbprefix('sales') .".biller as billers,
				" . $this->db->dbprefix('sales') . ".customer as customers, " . $this->db->dbprefix('sales') . ".sale_status as sale_statuses, 
				" . $this->db->dbprefix('sales') . ".grand_total as grand_totals, (".$this->db->dbprefix('sales').".paid + (".$this->db->dbprefix('sales').".other_cur_paid / ".$this->db->dbprefix('sales').".other_cur_paid_rate)) as paids,
				(" . $this->db->dbprefix('sales') . ". grand_total - (".$this->db->dbprefix('sales').".paid + (".$this->db->dbprefix('sales').".other_cur_paid / ".$this->db->dbprefix('sales').".other_cur_paid_rate))) as balances,
				" . $this->db->dbprefix('sales') . ".payment_status as payment_statuses");
            $this->db->from('sales');
			$this->db->join('loans','sales.id=loans.reference_no','INNER');
            $this->db->group_by("loans.reference_no");
            if ($sales) {
                $this->db->where('sales.id', $sales);
            }

            $q = $this->db->get();
            if ($q->num_rows() > 0) {
                foreach (($q->result()) as $row) {
                    $data[] = $row;
                }
            } else {
                $data = NULL;
            }

            if (!empty($data)) {

                $this->load->library('excel');
                $this->excel->setActiveSheetIndex(0);
                $this->excel->getActiveSheet()->setTitle(lang('Sales List'));
				$this->excel->getActiveSheet()->SetCellValue('A1', lang('date'));
                $this->excel->getActiveSheet()->SetCellValue('B1', lang('reference_no'));
                $this->excel->getActiveSheet()->SetCellValue('C1', lang('biller'));
                $this->excel->getActiveSheet()->SetCellValue('D1', lang('customer'));
                $this->excel->getActiveSheet()->SetCellValue('E1', lang('sale_status'));
                $this->excel->getActiveSheet()->SetCellValue('F1', lang('grand_total'));
                $this->excel->getActiveSheet()->SetCellValue('G1', lang('paid'));
                $this->excel->getActiveSheet()->SetCellValue('H1', lang('balance'));
				$this->excel->getActiveSheet()->SetCellValue('I1', lang('payment_status'));

                $row = 2;
				
                foreach ($data as $data_row) {
                    //$this->excel->getActiveSheet()->SetCellValue('A' . $row, $this->erp->hrld($data_row->id));
                    $this->excel->getActiveSheet()->SetCellValue('A' . $row, $data_row->dates);
					$this->excel->getActiveSheet()->SetCellValue('B' . $row, $data_row->reference_nos);
                    $this->excel->getActiveSheet()->SetCellValue('C' . $row, $data_row->billers);
                    $this->excel->getActiveSheet()->SetCellValue('D' . $row, $data_row->customers);
                    $this->excel->getActiveSheet()->SetCellValue('E' . $row, $data_row->sale_statuses);
                    $this->excel->getActiveSheet()->SetCellValue('F' . $row, lang($data_row->grand_totals));
					$this->excel->getActiveSheet()->SetCellValue('G' . $row, lang($data_row->paids));
					$this->excel->getActiveSheet()->SetCellValue('H' . $row, lang($data_row->balances));
					$this->excel->getActiveSheet()->SetCellValue('I' . $row, lang($data_row->payment_statuses));
                    //$this->excel->getActiveSheet()->SetCellValue('G' . $row, $data_row->wh);
                    $row++;
                }

                $this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(20);
                $this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
                $this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
                $this->excel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
                $this->excel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
                $this->excel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
                $this->excel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
				$this->excel->getActiveSheet()->getColumnDimension('H')->setWidth(20);
                $filename = lang('Loans List');
                $this->excel->getDefaultStyle()->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                if ($pdf) {
                    $styleArray = array(
                        'borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN))
                    );
                    $this->excel->getDefaultStyle()->applyFromArray($styleArray);
                    $this->excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
                    require_once(APPPATH . "third_party" . DIRECTORY_SEPARATOR . "MPDF" . DIRECTORY_SEPARATOR . "mpdf.php");
                    $rendererName = PHPExcel_Settings::PDF_RENDERER_MPDF;
                    $rendererLibrary = 'MPDF';
                    $rendererLibraryPath = APPPATH . 'third_party' . DIRECTORY_SEPARATOR . $rendererLibrary;
                    if (!PHPExcel_Settings::setPdfRenderer($rendererName, $rendererLibraryPath)) {
                        die('Please set the $rendererName: ' . $rendererName . ' and $rendererLibraryPath: ' . $rendererLibraryPath . ' values' .
                            PHP_EOL . ' as appropriate for your directory structure');
                    }

                    header('Content-Type: application/pdf');
                    header('Content-Disposition: attachment;filename="' . $filename . '.pdf"');
                    header('Cache-Control: max-age=0');

                    $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'PDF');
                    $objWriter->save('php://output');
                    exit();
                }
                if ($excel) {
                    ob_clean();
                    header('Content-Type: application/vnd.ms-excel');
                    header('Content-Disposition: attachment;filename="' . $filename . '.xls"');
                    header('Cache-Control: max-age=0');
                    ob_clean();
                    $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
                    $objWriter->save('php://output');
                    exit();
                }

            }

            $this->session->set_flashdata('error', lang('nothing_found'));
            redirect($_SERVER["HTTP_REFERER"]);

        }
    }
	//-------------------End Loan export--------------------------------------
    
	//------------------- Sale export as Excel and pdf -----------------------
	function getReturnsAll($pdf = NULL, $excel = NULL)
    {
        $this->erp->checkPermissions('Sales');

        $sales = $this->input->get('sales') ? $this->input->get('sales') : NULL;

        if ($pdf || $excel) {

            $this->db
                ->select($this->db->dbprefix('return_sales') . ".date as date, " . $this->db->dbprefix('return_sales') . ".reference_no as ref, 
							erp_sales.reference_no AS `sal_ref`,
						" . $this->db->dbprefix('return_sales') . ".biller, " . $this->db->dbprefix('return_sales') . ".customer, " . $this->db->dbprefix('return_sales') . ".surcharge, " . $this->db->dbprefix('return_sales') . ".grand_total, " . $this->db->dbprefix('return_sales') . ".id as id")
                ->join('sales', 'sales.id=return_sales.sale_id', 'left')
                ->from('return_sales')
                ->group_by('return_sales.id');
            if ($sales) {
                $this->db->where('sales.id', $sales);
            }

            $q = $this->db->get();
            if ($q->num_rows() > 0) {
                foreach (($q->result()) as $row) {
                    $data[] = $row;
                }
            } else {
                $data = NULL;
            }

            if (!empty($data)) {

                $this->load->library('excel');
                $this->excel->setActiveSheetIndex(0);
                $this->excel->getActiveSheet()->setTitle(lang('return_sales'));
				$this->excel->getActiveSheet()->SetCellValue('A1', lang('date'));
                $this->excel->getActiveSheet()->SetCellValue('B1', lang('reference_no'));
                $this->excel->getActiveSheet()->SetCellValue('C1', lang('sale_reference'));
                $this->excel->getActiveSheet()->SetCellValue('D1', lang('shop'));
                $this->excel->getActiveSheet()->SetCellValue('E1', lang('customer'));
                $this->excel->getActiveSheet()->SetCellValue('F1', lang('surcharge'));
                $this->excel->getActiveSheet()->SetCellValue('G1', lang('grand_total'));

                $row = 2;
				
                foreach ($data as $data_row) {
                    $this->excel->getActiveSheet()->SetCellValue('A' . $row, $data_row->date);
					$this->excel->getActiveSheet()->SetCellValue('B' . $row, $data_row->ref);
                    $this->excel->getActiveSheet()->SetCellValue('C' . $row, $data_row->sal_ref);
                    $this->excel->getActiveSheet()->SetCellValue('D' . $row, $data_row->biller);
                    $this->excel->getActiveSheet()->SetCellValue('E' . $row, $data_row->customer);
                    $this->excel->getActiveSheet()->SetCellValue('F' . $row, lang($data_row->surcharge));
					$this->excel->getActiveSheet()->SetCellValue('G' . $row, lang($data_row->grand_total));
                    $row++;
                }

                $this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(20);
                $this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
                $this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
                $this->excel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
                $this->excel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
                $this->excel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
                $this->excel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
				$this->excel->getActiveSheet()->getColumnDimension('H')->setWidth(20);
                $filename = lang('return_sales');
                $this->excel->getDefaultStyle()->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                if ($pdf) {
                    $styleArray = array(
                        'borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN))
                    );
                    $this->excel->getDefaultStyle()->applyFromArray($styleArray);
                    $this->excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
                    require_once(APPPATH . "third_party" . DIRECTORY_SEPARATOR . "MPDF" . DIRECTORY_SEPARATOR . "mpdf.php");
                    $rendererName = PHPExcel_Settings::PDF_RENDERER_MPDF;
                    $rendererLibrary = 'MPDF';
                    $rendererLibraryPath = APPPATH . 'third_party' . DIRECTORY_SEPARATOR . $rendererLibrary;
                    if (!PHPExcel_Settings::setPdfRenderer($rendererName, $rendererLibraryPath)) {
                        die('Please set the $rendererName: ' . $rendererName . ' and $rendererLibraryPath: ' . $rendererLibraryPath . ' values' .
                            PHP_EOL . ' as appropriate for your directory structure');
                    }

                    header('Content-Type: application/pdf');
                    header('Content-Disposition: attachment;filename="' . $filename . '.pdf"');
                    header('Cache-Control: max-age=0');

                    $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'PDF');
                    $objWriter->save('php://output');
                    exit();
                }
                if ($excel) {
                    ob_clean();
                    header('Content-Type: application/vnd.ms-excel');
                    header('Content-Disposition: attachment;filename="' . $filename . '.xls"');
                    header('Cache-Control: max-age=0');
                    ob_clean();
                    $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
                    $objWriter->save('php://output');
                    exit();
                }

            }

            $this->session->set_flashdata('error', lang('nothing_found'));
            redirect($_SERVER["HTTP_REFERER"]);

        }
    }
	//-------------------End Sale export -------------------------------------
	
    public function getSaleReturnQuantity() {
        if ($this->input->get('sale_ref')) {
            $sale_ref = $this->input->get('sale_ref', TRUE);
        }
        if ($this->input->get('product_id')) {
            $product_id = $this->input->get('product_id', TRUE);
        }
		
        $quantity = $this->sales_model->getSaleItemByRefPIDReturn($sale_ref, $product_id);
        $quantity = $quantity->quantity;
        echo json_encode($quantity);
    }
	
	function getDeliveryList($start = NULL, $end = NULL)
    {
        $this->erp->checkPermissions('deliveries');

		$print_cabon_link = anchor('sales/view_delivery_cabon/$1', '<i class="fa fa-file-text-o"></i> ' . lang('print_cabon'), 'data-toggle="modal" data-target="#myModal"');
        $detail_link = anchor('sales/view_delivery/$1', '<i class="fa fa-file-text-o"></i> ' . lang('delivery_details'), 'data-toggle="modal" data-target="#myModal"');
		$add_link = anchor('sales/delivery_added/$1', '<i class="fa fa-file-text-o"></i> ' . lang('add_delivery'));
		$update_link = anchor('sales/delivery_update/$1', '<i class="fa fa-file-text-o"></i> ' . lang('update_delivery'), 'data-toggle="modal" data-target="#myModal"');
        $email_link = anchor('sales/email_delivery/$1', '<i class="fa fa-envelope"></i> ' . lang('email_delivery'), 'data-toggle="modal" data-target="#myModal"');
        $edit_link = anchor('sales/edit_delivery/$1', '<i class="fa fa-edit"></i> ' . lang('edit_delivery'), 'data-toggle="modal" data-target="#myModal"');
        $pdf_link = anchor('sales/pdf_delivery/$1', '<i class="fa fa-file-pdf-o"></i> ' . lang('download_pdf'));
        $delete_link = "<a href='#' class='po' title='<b>" . lang("delete_delivery") . "</b>' data-content=\"<p>"
            . lang('r_u_sure') . "</p><a class='btn btn-danger po-delete' href='" . site_url('sales/delete_delivery/$1') . "'>"
            . lang('i_m_sure') . "</a> <button class='btn po-close'>" . lang('no') . "</button>\"  rel='popover'><i class=\"fa fa-trash-o\"></i> "
            . lang('delete_delivery') . "</a>";
        $action = '<div class="text-center"><div class="btn-group text-left">'
            . '<button type="button" class="btn btn-default btn-xs btn-primary dropdown-toggle" data-toggle="dropdown">'
            . lang('actions') . ' <span class="caret"></span></button>
    <ul class="dropdown-menu pull-right" role="menu">
        <li>' . $print_cabon_link . '</li>

		<li>' . $update_link . '</li>
		<li>' . $detail_link . '</li>'

		.(($this->Owner || $this->Admin) ? '<li>'.$edit_link.'</li>' : ($this->GP['sales-edit_delivery'] ? '<li>'.$edit_link.'</li>' : '')).

		'<li>' . $pdf_link . '</li>
        <li>' . $delete_link . '</li>
    </ul>
</div></div>';

        $this->load->library('datatables');
        //GROUP_CONCAT(CONCAT('Name: ', sale_items.product_name, ' Qty: ', sale_items.quantity ) SEPARATOR '<br>')

		$this->datatables
            ->select("deliveries.id as id, deliveries.date, deliveries.do_reference_no, deliveries.sale_reference_no,
					deliveries.customer,CONCAT(".$this->db->dbprefix('users').".first_name, ' ',".$this->db->dbprefix('users').".last_name),companies.name, deliveries.address,
					COALESCE(SUM(erp_delivery_items.quantity_received),0) as qauantity_received
					")
            ->from('deliveries')
			->join('sales','deliveries.sale_id=sales.id')
			->join('users','sales.saleman_by=users.id')
			->join('companies','deliveries.delivery_by=companies.id','left')
            ->join('delivery_items', 'deliveries.id=delivery_items.delivery_id', 'left')
            ->group_by('deliveries.id')
			->order_by('deliveries.id', 'asc');
		if($start && $end){
			$this->datatables->where('date BETWEEN "' . $start . '" AND "' . $end . '"');
		}

        $this->datatables->add_column("Actions", $action, "id");

        echo $this->datatables->generate();
    }
	
	
	function delivery_list(){

        $this->erp->checkPermissions();

		if (!$start_date) {
            //$start = $this->db->escape(date('Y-m') . '-1');
           // $start_date = date('Y-m') . '-1';
        } else {
            $start = $this->db->escape(urldecode($start_date));
        }
        if (!$end_date) {
            //$end = $this->db->escape(date('Y-m-d H:i'));
            //$end_date = date('Y-m-d H:i');
        } else {
            $end = $this->db->escape(urldecode($end_date));
        }

        $data['error'] = (validation_errors() ? validation_errors() : $this->session->flashdata('error'));

		$this->data['start'] = urldecode($start_date);
        $this->data['end'] = urldecode($end_date);

        $bc = array(array('link' => base_url(), 'page' => lang('home')), array('link' => site_url('sales'), 'page' => lang('sales')), array('link' => '#', 'page' => lang('deliveries_list')));
        $meta = array('page_title' => lang('deliveries_list'), 'bc' => $bc);
        $this->page_construct('sales/deliveries_list', $meta, $this->data);
	}
	
	function delivery_added($id = NULL,$status=Null)
	{
        $this->erp->checkPermissions('deliveries');
		$this->form_validation->set_rules('customer', lang("customer"), 'required');
		$this->form_validation->set_rules('delivery_by', lang("delivery_by"), 'required');
		$this->form_validation->set_rules('reference_no', lang("reference_no"), 'trim|is_unique[sales.reference_no]');

        if ($this->form_validation->run() == true) {

        } else {
			
			$this->data['error'] = (validation_errors() ? validation_errors() : $this->session->flashdata('error'));
			$date = date('d/m/Y H:i');
			$this->data['date'] = $date;
			
			$this->data['status'] = $status;
			
			if($status == 'sale_order'){
				$this->data['tax_rates'] = $this->site->getAllTaxRates();
				$div = $this->sales_model->getSaleOrder($id);
				$this->data['deliveries'] = $div;
				$this->data['delivery_items'] = $this->sales_model->getSaleOrderItems($id);
				$this->data['reference'] = $this->site->getReference('do',$div->biller_id);
				$this->data['user'] = $this->sales_model->getUserFromSaleOrderByID($id);
			}
			
			if($status == 'invoice'){
				$this->data['tax_rates'] = $this->site->getAllTaxRates();
				$div = $this->sales_model->getSaleRecordByID($id);
				$this->data['deliveries'] = $div;
				$this->data['delivery_items'] = $this->sales_model->getSaleItemBySaleID($id);
				$this->data['user'] = $this->sales_model->getUserFromSaleBySaleID($id);
				$this->data['reference'] = $this->site->getReference('do',$div->biller_id);
			}

			$this->data['setting'] = $this->site->get_setting();
			$this->data['drivers'] = $this->site->getDrivers();
			$this->data['modal_js'] = $this->site->modal_js();
            $bc = array(array('link' => base_url(), 'page' => lang('home')), array('link' => site_url('sales'), 'page' => lang('sales')), array('link' => '#', 'page' => lang('add_deliveries')));
            $meta = array('page_title' => lang('add_deliveries'), 'bc' => $bc);
            $this->page_construct('sales/delivery_added', $meta, $this->data);
        }

    }
	
	public function sale_edit(){
		$id   = $_REQUEST['id'];
		$qty  = $_REQUEST['qty'];
		$edit = $_REQUEST['edit_id'];
		$warehouse = $_REQUEST['ware'];
		$this->sales_model->saleEdit($id, $qty, $edit, $warehouse);
	}
	
	public function product_serial($warehouse_id = NULL){
		$this->erp->checkPermissions();

        $this->data['error'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('error');
        if ($this->Owner) {
            $this->data['warehouses'] = $this->site->getAllWarehouses();
            $this->data['warehouse_id'] = $warehouse_id;
            $this->data['warehouse'] = $warehouse_id ? $this->site->getWarehouseByID($warehouse_id) : NULL;
        } else {
            $user = $this->site->getUser();
            $this->data['warehouses'] = NULL;
            $this->data['warehouse_id'] = $user->warehouse_id;
            $this->data['warehouse'] = $user->warehouse_id ? $this->site->getWarehouseByID($user->warehouse_id) : NULL;
        }

        $bc = array(array('link' => base_url(), 'page' => lang('home')), array('link' => '#', 'page' => lang('products_serial')));
        $meta = array('page_title' => lang('products_serial'), 'bc' => $bc);
        $this->page_construct('sales/products_serial', $meta, $this->data);
	}
	/*======================================chin local updated=======================================*/
	function getSaleOrderitems($start = NULL, $end = NULL)
    {
		
        $this->erp->checkPermissions('deliveries');

		$print_cabon_link = anchor('sales/view_delivery_cabon/$1', '<i class="fa fa-file-text-o"></i> ' . lang('print_cabon'), 'data-toggle="modal" data-target="#myModal"');
        $detail_link = anchor('sales/view_delivery/$1', '<i class="fa fa-file-text-o"></i> ' . lang('delivery_details'), 'data-toggle="modal" data-target="#myModal"');
		$add_link = anchor('sales/delivery_add/$1', '<i class="fa fa-file-text-o"></i> ' . lang('add_delivery'), 'data-toggle="modal" data-target="#myModal"');
		$update_link = anchor('sales/delivery_update/$1', '<i class="fa fa-file-text-o"></i> ' . lang('update_delivery'), 'data-toggle="modal" data-target="#myModal"');
        $email_link = anchor('sales/email_delivery/$1', '<i class="fa fa-envelope"></i> ' . lang('email_delivery'), 'data-toggle="modal" data-target="#myModal"');
        $edit_link = anchor('sales/edit_delivery/$1', '<i class="fa fa-edit"></i> ' . lang('edit_delivery'), 'data-toggle="modal" data-target="#myModal"');
        $pdf_link = anchor('sales/pdf_delivery/$1', '<i class="fa fa-file-pdf-o"></i> ' . lang('download_pdf'));
        $delete_link = "<a href='#' class='po' title='<b>" . lang("delete_delivery") . "</b>' data-content=\"<p>"
            . lang('r_u_sure') . "</p><a class='btn btn-danger po-delete' href='" . site_url('sales/delete_delivery/$1') . "'>"
            . lang('i_m_sure') . "</a> <button class='btn po-close'>" . lang('no') . "</button>\"  rel='popover'><i class=\"fa fa-trash-o\"></i> "
            . lang('delete_delivery') . "</a>";
        $action = '<div class="text-center"><div class="btn-group text-left">'
            . '<button type="button" class="btn btn-default btn-xs btn-primary dropdown-toggle" data-toggle="dropdown">'
            . lang('actions') . ' <span class="caret"></span></button>
		<ul class="dropdown-menu pull-right" role="menu">
        <li>' . $print_cabon_link . '</li>
		<li>' . $add_link . '</li>
		<li>' . $update_link . '</li>
		<li>' . $detail_link . '</li>'

		.(($this->Owner || $this->Admin) ? '<li>'.$edit_link.'</li>' : ($this->GP['sales-edit_delivery'] ? '<li>'.$edit_link.'</li>' : '')).

		'<li>' . $pdf_link . '</li>
        <li>' . $delete_link . '</li>
    </ul>
	</div></div>';

        $this->load->library('datatables');
        //GROUP_CONCAT(CONCAT('Name: ', sale_items.product_name, ' Qty: ', sale_items.quantity ) SEPARATOR '<br>')

		$this->datatables
            ->select("sale_order.id as id, sale_order.date, sale_order.reference_no, project.company, cust.name as customer, users.username, 
					COALESCE(SUM(erp_sale_order_items.quantity),0) as qty, 
					COALESCE(SUM(erp_sale_order_items.quantity_received),0) as qty_received, 
					COALESCE(SUM(erp_sale_order_items.quantity),0) - COALESCE(SUM(erp_sale_order_items.quantity_received),0) as balance, 
					(IF(ISNULL(".$this->db->dbprefix("sale_order").".delivery_status), CONCAT(erp_sale_order.id, '___', 'delivery'), CONCAT(erp_sale_order.id, '___', ".$this->db->dbprefix("sale_order").".delivery_status))) as delivery_status")
            ->from('sale_order')
			->join('companies as erp_cust', 'cust.id = sale_order.customer_id', 'inner')
			->join('companies as erp_project', 'project.id = sale_order.biller_id', 'inner')
			->join('users','sale_order.saleman_by=users.id','left')
			->join('sale_order_items','sale_order.id=sale_order_items.sale_order_id','left')
			->where('sale_order.sale_status <>', 'sale')
			->group_by('sale_order.id');
		if($start && $end){
			$this->datatables->where('date BETWEEN "' . $start . '" AND "' . $end . '"');
		}
        //$this->datatables->add_column("Actions", $action, "id");

        echo $this->datatables->generate();
    }
	/*=======================================end local updated=================================*/
	
	function getSales_items($start = NULL, $end = NULL)
    {
        $this->erp->checkPermissions('deliveries');
		$print_cabon_link = anchor('sales/view_delivery_cabon/$1', '<i class="fa fa-file-text-o"></i> ' . lang('print_cabon'), 'data-toggle="modal" data-target="#myModal"');
        $detail_link = anchor('sales/view_delivery/$1', '<i class="fa fa-file-text-o"></i> ' . lang('delivery_details'), 'data-toggle="modal" data-target="#myModal"');
		$add_link = anchor('sales/delivery_add/$1', '<i class="fa fa-file-text-o"></i> ' . lang('add_delivery'), 'data-toggle="modal" data-target="#myModal"');
		$update_link = anchor('sales/delivery_update/$1', '<i class="fa fa-file-text-o"></i> ' . lang('update_delivery'), 'data-toggle="modal" data-target="#myModal"');
        $email_link = anchor('sales/email_delivery/$1', '<i class="fa fa-envelope"></i> ' . lang('email_delivery'), 'data-toggle="modal" data-target="#myModal"');
        $edit_link = anchor('sales/edit_delivery/$1', '<i class="fa fa-edit"></i> ' . lang('edit_delivery'), 'data-toggle="modal" data-target="#myModal"');
        $pdf_link = anchor('sales/pdf_delivery/$1', '<i class="fa fa-file-pdf-o"></i> ' . lang('download_pdf'));
        $delete_link = "<a href='#' class='po' title='<b>" . lang("delete_delivery") . "</b>' data-content=\"<p>"
            . lang('r_u_sure') . "</p><a class='btn btn-danger po-delete' href='" . site_url('sales/delete_delivery/$1') . "'>"
            . lang('i_m_sure') . "</a> <button class='btn po-close'>" . lang('no') . "</button>\"  rel='popover'><i class=\"fa fa-trash-o\"></i> "
            . lang('delete_delivery') . "</a>";
        $action = '<div class="text-center"><div class="btn-group text-left">'
            . '<button type="button" class="btn btn-default btn-xs btn-primary dropdown-toggle" data-toggle="dropdown">'
            . lang('actions') . ' <span class="caret"></span></button>
		<ul class="dropdown-menu pull-right" role="menu">
        <li>' . $print_cabon_link . '</li>
		<li>' . $add_link . '</li>
		<li>' . $update_link . '</li>
		<li>' . $detail_link . '</li>'

		.(($this->Owner || $this->Admin) ? '<li>'.$edit_link.'</li>' : ($this->GP['sales-edit_delivery'] ? '<li>'.$edit_link.'</li>' : '')).

		'<li>' . $pdf_link . '</li>
        <li>' . $delete_link . '</li>
    </ul>
	</div></div>';

        $user_id = $this->session->userdata('user_id');
        $biller_id = $this->session->userdata('biller_id');
        // $this->erp->print_arrays($biller_id);exit;
        $this->load->library('datatables');
        //GROUP_CONCAT(CONCAT('Name: ', sale_items.product_name, ' Qty: ', sale_items.quantity ) SEPARATOR '<br>')
        if ($biller_id) {
            $this->datatables
                ->select("sales.id as id, sales.date, sales.reference_no, pro.company, sales.customer, users.username, 
                        COALESCE(SUM(erp_sale_items.quantity),0) as qty, COALESCE(SUM(erp_sale_items.quantity_received),0) as qty_received,
                        COALESCE(SUM(erp_sale_items.quantity),0) - COALESCE(SUM(erp_sale_items.quantity_received),0) as balance,
                        (IF(ISNULL(".$this->db->dbprefix("sales").".delivery_status), CONCAT(erp_sales.id, '___', 'delivery'),
                        CONCAT(erp_sales.id, '___', ".$this->db->dbprefix("sales").".delivery_status))) as delivery_status")
                ->from('sales')
                ->join('users','sales.saleman_by=users.id','left')
                ->join('companies as erp_pro', 'pro.id = sales.biller_id', 'left')
                ->join('sale_items','sales.id=sale_items.sale_id','left')
                ->where('sales.sale_status <>','returned')
                ->where('sales.biller_id', $biller_id)
                ->group_by('sales.id');
        } else {

    		$this->datatables
                ->select("sales.id as id, sales.date, sales.reference_no, pro.company, sales.customer, users.username, 
    					COALESCE(SUM(erp_sale_items.quantity),0) as qty, COALESCE(SUM(erp_sale_items.quantity_received),0) as qty_received,
    					COALESCE(SUM(erp_sale_items.quantity),0) - COALESCE(SUM(erp_sale_items.quantity_received),0) as balance,
    					(IF(ISNULL(".$this->db->dbprefix("sales").".delivery_status), CONCAT(erp_sales.id, '___', 'delivery'),
    					CONCAT(erp_sales.id, '___', ".$this->db->dbprefix("sales").".delivery_status))) as delivery_status")
                ->from('sales')
    			->join('users','sales.saleman_by=users.id','left')
    			->join('companies as erp_pro', 'pro.id = sales.biller_id', 'left')
    			->join('sale_items','sales.id=sale_items.sale_id','left')
    			->where('sales.sale_status <>','returned')
    			->group_by('sales.id');
        }

		if($start && $end){
			$this->datatables->where('date BETWEEN "' . $start . '" AND "' . $end . '"');
		}

        //$this->datatables->add_column("Actions", $action, "id");

        echo $this->datatables->generate();
    }
	
	function add_deliveries($start_date = NULL, $end_date = NULL)
    {
        
        $this->erp->checkPermissions('add_delivery',NULL,'sales');

		if (!$start_date) {
            //$start = $this->db->escape(date('Y-m') . '-1');
           // $start_date = date('Y-m') . '-1';
        } else {
            $start = $this->db->escape(urldecode($start_date));
        }
        if (!$end_date) {
            //$end = $this->db->escape(date('Y-m-d H:i'));
            //$end_date = date('Y-m-d H:i');
        } else {
            $end = $this->db->escape(urldecode($end_date));
        }

        $data['error'] = (validation_errors() ? validation_errors() : $this->session->flashdata('error'));

		$this->data['start'] = urldecode($start_date);
        $this->data['end'] = urldecode($end_date);

        $bc = array(array('link' => base_url(), 'page' => lang('home')), array('link' => site_url('sales'), 'page' => lang('sales')), array('link' => '#', 'page' => lang('deliveries')));
        $meta = array('page_title' => lang('deliveries'), 'bc' => $bc);
        $this->page_construct('sales/add_deliveries', $meta, $this->data);
    }
	
	/*==================================chin local updated=================================*/
	function add_new_delivery() {

		// get deliveries and add deliveries and add delivery_items

		$date = date('Y-m-d H:i:s');
		$sale_id = $this->input->post('sale_id');
		
		$sale_reference_no = $this->input->post('sale_reference');
		$customer_id = $this->input->post('customer_id');
		$biller_id = $this->input->post('biller_id');
		$customer = $this->site->getCompanyByID($customer_id);
		$address = $customer->address .' '. $customer->city .' '. $customer->state .' '. $customer->postal_code .' '. $customer->country .'<br/> Tel: '. $customer->phone .' Email: '. $customer->email;
		$note = $this->input->post('note');
		$created_by = $this->input->post('saleman_by');
		$delivery_by = $this->input->post('delivery_by');
		$do_reference_no = $this->site->getReference('do',$biller_id);
		
		$type = $this->input->post('status');
		$delivery_status = $this->input->post('delivery_status');
		
		$delivery = array(
			'date' 				=> $date,
			'sale_id' 			=> $sale_id,
			'do_reference_no' 	=> $do_reference_no,
			'sale_reference_no' => $sale_reference_no,
			'biller_id' 		=> $biller_id,
			'customer_id' 		=> $customer_id,
			'customer' 			=> $customer->name,
			'address' 			=> $address,
			'note' 				=> $note,
			'type' 				=> $type,
			'delivery_by' 		=> $delivery_by,
			'created_by' 		=> $this->session->userdata('user_id'),
			'sale_status' 		=> 'pending',
			'delivery_status' 	=> $delivery_status
		);
		
		
		if($delivery){
			
			$product_id 	= $this->input->post('product_id');
			$warehouse_id 	= $this->input->post('warehouse_id');
			$quantity 		= $this->input->post('bquantity');	
			$quantity_received = $this->input->post('cur_quantity_received');
			$option_id = $this->input->post('option_id');
			$sale_item_id = $this->input->post('delivery_id');
			$product_id = $this->input->post('product_id');
			$product_code = $this->input->post('product_code');
			$product_name = $this->input->post('product_name');
			$product_type = $this->input->post('product_type');
			$items_id = $this->input->post('delivery_id');
			
			$pro_num = sizeof($product_id);
				for($i=0; $i<$pro_num; $i++) {
					$rec_quantity = $quantity_received[$i];
					$b_quantity = $quantity[$i];
					$ending_balance = $quantity[$i] - $quantity_received[$i];
					
					$deliverie_items[] =  array(
						'item_id' 			=> $items_id[$i],
						'product_id' 		=> $product_id[$i],
						'sale_id' 			=> $sale_id,
						'product_name' 		=> $product_name[$i],
						'product_type' 		=> $product_type[$i],
						'option_id' 		=> $option_id[$i],
						'warehouse_id' 		=> $warehouse_id[$i],
						'begining_balance' 	=> $b_quantity,
						'quantity_received' => $rec_quantity,
						'ending_balance' 	=> $ending_balance,
						'created_by' 		=> $this->session->userdata('user_id'),
					);
				}
				//$this->erp->print_arrays($delivery,$deliverie_items);
			
			$delivery_id = $this->sales_model->add_delivery($delivery, $deliverie_items);
			if($delivery_id > 0){
				$invoice_status = false;
				$sale_order_status = false;
				if($type == "invoice") {
					$sale_item = $this->sales_model->getSItemsBySaleID($sale_id);
					for($i=0; $i< sizeof($sale_item); $i++){
						$qtyReceived = $sale_item[$i]->quantity_received;
						$lastQtyReceived = $qtyReceived + $quantity_received[$i];
						
						$qty_received = array('quantity_received' => $lastQtyReceived);
						$condition = array('id' => $sale_item_id[$i],'product_id' => $product_id[$i],'product_name' => $product_name[$i], 'product_code' => $product_code[$i],'sale_id'=>$sale_id);
						if($this->sales_model->updateSaleItemQtyReceived($qty_received,$condition)){
							$invoice_status = true;
						}
					}
				}
				
				if($type=="sale_order") {
					$sale_order_item = $this->sales_model->getSaleOrderItem($sale_id);
					for($i=0;$i<sizeof($sale_order_item);$i++){
						$qtyReceived = $sale_order_item[$i]->quantity_received;
						$lastQtyReceived = $qtyReceived + $quantity_received[$i];
						$qty_received = array('quantity_received' => $lastQtyReceived);
						$condition = array('id' => $sale_item_id[$i],'product_id' => $product_id[$i],'product_name' => $product_name[$i], 'product_code' => $product_code[$i],'sale_order_id'=>$sale_id);
						if($this->sales_model->updateSaleOrderQtyReceived($qty_received,$condition)){
							$sale_order_status = true;
						}
					}
				}
				
				if($invoice_status == true) {
				// update delivery status
					$getAllQty = $this->sales_model->getAllSaleItemQty($sale_id);
					$updateStatus = false;
					foreach($getAllQty as $qty){
						
						if($qty->qty - $qty->qty_received > 0){
							$status = array('delivery_status' => 'partial');
							$condition = array('id'=>$sale_id);
							$this->db->where($condition);
							$this->db->update('sales', $status);
							$updateStatus = true;
							
						}elseif($qty->qty - $qty->qty_received == 0){
							$status = array('delivery_status' => 'completed');
							$condition = array('id'=>$sale_id);
							$this->db->where($condition);
							$this->db->update('sales', $status);
							$updateStatus = true;	
						}

					}
					
					if($updateStatus == true) {
						// update stock here....
						foreach($deliverie_items as $delivery_item){
							
							$delivery_quantity = $delivery_item['quantity_received'];
							$getproduct = $this->site->getProductByID($delivery_item['product_id']);
							$getsaleitem = $this->sales_model->getSaleItemByID($delivery_item['item_id']);
							
							$stock_info[] = array(
								'product_id' 		=> $delivery_item['product_id'],
								'product_code' 		=> $getproduct->code,
								'product_name' 		=> $delivery_item['product_name'],
								'product_type' 		=> $getproduct->type,
								'option_id' 		=> $delivery_item['option_id'],
								'net_unit_price' 	=> $getsaleitem->net_unit_price,
								'unit_price' 		=> $getsaleitem->unit_price,
								'quantity' 			=> $delivery_quantity,
								'warehouse_id' 		=> $delivery_item['warehouse_id'],
								'item_tax' 			=> $getsaleitem->item_tax,
								'tax_rate_id' 		=> $getsaleitem->tax_rate_id,
								'tax' 				=> $getsaleitem->tax,
								'discount' 			=> $getsaleitem->discount,
								'item_discount' 	=> $getsaleitem->item_discount,
								'subtotal' 			=> $getsaleitem->subtotal,
								'serial_no' 		=> $getsaleitem->serial_no,
								'real_unit_price' 	=> $getsaleitem->real_unit_price,
								'product_noted' 	=> $getsaleitem->product_noted,
								'transaction_type'	=> 'DELIVERY',
								'transaction_id'	=> $getsaleitem->id,
								'status'			=> ($delivery_status == 'completed'? 'received':'pending')
							);
							
						}
						
						if(sizeof($stock_info) >0){
							if($delivery_status == "completed") {
								$cost = $this->site->costing($stock_info);
								$this->site->syncPurchaseItems($cost);
								$this->site->syncQuantity(NULL, NULL, NULL, NULL, NULL, NULL, $stock_info);
							}
							$this->session->set_flashdata('message', lang("delivery added successfully"));
							redirect("sales/add_deliveries");
						}
						
					}
					
				}
				
				if($sale_order_status == true){
				// update delivery status
					$getAllQty = $this->sales_model->getAllSaleOrderItemQty($sale_id);
					$updateStatus = false;
					foreach($getAllQty as $qty){
						if($qty->qty - $qty->qty_received > 0){
							$status = array('delivery_status' => 'partial', 'sale_status' => 'delivery');
							$condition = array('id'=>$sale_id);
							$this->db->where($condition);
							$this->db->update('sale_order', $status);
							$updateStatus = true;
							
						}elseif($qty->qty - $qty->qty_received == 0){
							$status = array('delivery_status' => 'completed', 'sale_status' => 'delivery');
							$condition = array('id'=>$sale_id);
							$this->db->where($condition);
							$this->db->update('sale_order', $status);
							$updateStatus = true;	
						}

					}
					
					if($updateStatus == true) {
						// update stock here....
						foreach($deliverie_items as $delivery_item){
							
							$delivery_quantity = $delivery_item['quantity_received'];
							$getproduct = $this->site->getProductByID($delivery_item['product_id']);
							$getsaleitem = $this->sales_model->getSaleOrderItemByID($delivery_item['item_id']);
							
							$stock_info[] = array(
								'product_id' => $delivery_item['product_id'],
								'product_code' => $getproduct->code,
								'product_name' => $delivery_item['product_name'],
								'product_type' => $getproduct->type,
								'option_id' => $delivery_item['option_id'],
								'net_unit_price' => $getsaleitem->net_unit_price,
								'unit_price' => $getsaleitem->unit_price,
								'quantity' => $delivery_quantity,
								'warehouse_id' => $delivery_item['warehouse_id'],
								'item_tax' => $getsaleitem->item_tax,
								'tax_rate_id' => $getsaleitem->tax_rate_id,
								'tax' => $getsaleitem->tax,
								'discount' => $getsaleitem->discount,
								'item_discount' => $getsaleitem->item_discount,
								'subtotal' => $getsaleitem->subtotal,
								'serial_no' => $getsaleitem->serial_no,
								'real_unit_price' => $getsaleitem->real_unit_price,
								'product_noted' => $getsaleitem->product_noted
							);
							
						}
						
						if(sizeof($stock_info) > 0) {
							if($delivery_status == "completed") {
								$cost = $this->site->costing($stock_info);
								$this->site->syncPurchaseItems($cost);
								$this->site->syncQuantity(NULL, NULL, NULL, NULL, NULL, NULL, $stock_info);
							}
							$this->session->set_flashdata('message', lang("delivery added successfully"));
							redirect("sales/add_deliveries");
						}
						
					}
					
				}
			
			}else{
				$this->session->set_flashdata('error', lang("delivery not inserted"));
				redirect($_SERVER["HTTP_REFERER"]);
			}

		}

	}
	/*=============================================end local updated============================================*/
	
	
	public function getProductSerial($warehouse_id = NULL){
		$this->erp->checkPermissions('product_serial');

        if (!$this->Owner && !$warehouse_id) {
            $user = $this->site->getUser();
            $warehouse_id = $user->warehouse_id;
        }

        $this->load->library('datatables');
        if ($warehouse_id) {
            $this->datatables
                ->select('sales.id as idd, products.image, sales.date, sales.reference_no, products.code, products.name as pname, categories.name as cname, products.cost, products.price, sale_items.quantity, products.unit, sale_items.serial_no')
				->join('sale_items', 'sales.id = sale_items.sale_id', 'left')
				->join('products', 'products.id = sale_items.product_id', 'left')
				->join('categories', 'products.category_id = categories.id', 'left')
                ->from('sales')
				->where('sale_items.serial_no != "" ')
				->where('sales.warehouse_id', $warehouse_id);
        } 
		else {
			$this->datatables
                ->select('sales.id as idd, products.image, sales.date, sales.reference_no, products.code, products.name as pname, categories.name as cname, products.cost, products.price, sale_items.quantity, products.unit, sale_items.serial_no')
				->join('sale_items', 'sales.id = sale_items.sale_id', 'left')
				->join('products', 'products.id = sale_items.product_id', 'left')
				->join('categories', 'products.category_id = categories.id', 'left')
                ->from('sales')
				->where('sale_items.serial_no != "" ');
        }
        echo $this->datatables->generate();
	}
		function payment_schedule($pdf = NULL, $excel = NULL)
    {
        $this->erp->checkPermissions('Sales');

        $sales = $this->input->get('sales') ? $this->input->get('sales') : NULL;

        if ($pdf || $excel) {

            $this->db
                ->select($this->db->dbprefix('return_sales') . ".date as date, " . $this->db->dbprefix('return_sales') . ".reference_no as ref, 
							erp_sales.reference_no AS `sal_ref`,
						" . $this->db->dbprefix('return_sales') . ".biller, " . $this->db->dbprefix('return_sales') . ".customer, " . $this->db->dbprefix('return_sales') . ".surcharge, " . $this->db->dbprefix('return_sales') . ".grand_total, " . $this->db->dbprefix('return_sales') . ".id as id")
                ->join('sales', 'sales.id=return_sales.sale_id', 'left')
                ->from('return_sales')
                ->group_by('return_sales.id');
            if ($sales) {
                $this->db->where('sales.id', $sales);
            }

            $q = $this->db->get();
            if ($q->num_rows() > 0) {
                foreach (($q->result()) as $row) {
                    $data[] = $row;
                }
            } else {
                $data = NULL;
            }

            if (!empty($data)) {

                $this->load->library('excel');
                $this->excel->setActiveSheetIndex(0);
                $this->excel->getActiveSheet()->setTitle(lang('return_sales'));

                $this->excel->getActiveSheet()->SetCellValue('D3', lang('កាលវិភាកបង់ប្រាក់ប្រចំខែ Monthly Payment Schedule'));
                
				
				$this->excel->getActiveSheet()->SetCellValue('A7', lang('ឈ្មោះអតិថិជនៈ'));
				$this->excel->getActiveSheet()->SetCellValue('C7', lang('វ៉ាត សុម៉ៅ'));
				
				$this->excel->getActiveSheet()->SetCellValue('A8', lang('អាសយដ្ឋាន'));
				$this->excel->getActiveSheet()->SetCellValue('C8', lang('ភុមិ Trapeang Sang Chiek, សង្កាត់ ត្រពាំងគង'));
				$this->excel->getActiveSheet()->SetCellValue('C9', lang('សំរោងទង,កំពង់ស្ពឺ'));
				
				$this->excel->getActiveSheet()->SetCellValue('F9', lang('Dealer Number:'));
				$this->excel->getActiveSheet()->SetCellValue('G9', lang('KDL-04'));
				
				
				$this->excel->getActiveSheet()->SetCellValue('A10', lang('លេខទូរស័ព្ទ'));
				$this->excel->getActiveSheet()->SetCellValue('C10', lang('0966199788'));
				$this->excel->getActiveSheet()->SetCellValue('F10', lang('LID Number'));
				$this->excel->getActiveSheet()->SetCellValue('G10', lang('GLF-KDL-04-00047708'));
				
				$this->excel->getActiveSheet()->SetCellValue('A10', lang('លេខកូដក្រុមហ៊ុន:'));
				$this->excel->getActiveSheet()->SetCellValue('C10', lang('6777(បង់តាមវីង)'));
				$this->excel->getActiveSheet()->SetCellValue('F10', lang('លេសអតិថិជន:'));
				$this->excel->getActiveSheet()->SetCellValue('G10', lang(' 00047708'));
				
				$this->excel->getActiveSheet()->SetCellValue('B15', lang('ប្រភេទម៉ូតូ(Motorcycle model)'));
				$this->excel->getActiveSheet()->SetCellValue('D15', lang('ដ្រីម 125'));
				$this->excel->getActiveSheet()->SetCellValue('F15', lang('ទឹកប្រាក់'));
				$this->excel->getActiveSheet()->SetCellValue('H15', lang('ដ្រីម 125'));
				
				// Style ///
				$smallfont_blue = array(
				'font'  => array(
					'bold'  => false,
					'color' => array('rgb' => '3498db'),
					'size'  => 8,
					'name'  => ''
				));		
				$smallfont= array(
				'font'  => array(
					'bold'  => false,
					'color' => array('rgb' => '000000'),
					'size'  => 8,
					'name'  => ''
				));
				$this->excel->getActiveSheet()->getStyle('B15')->applyFromArray($smallfont);
				$border_style= array('borders' => array('allborders' => array('style' => 
					PHPExcel_Style_Border::BORDER_DASHED ,'color' => array('argb' => '000000'),)));
				$this->excel->getActiveSheet()->getStyle('D15')->applyFromArray($border_style)->applyFromArray($smallfont_blue)->getAlignment()->applyFromArray(
					array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,)
				);
				
				
				
				$this->excel->getActiveSheet()->getStyle('D3')->getFont()->setBold(true);
				$this->excel->getActiveSheet()->getStyle('A1')
        ->getFill()
        ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
        ->getStartColor()
        ->setRGB('FF0000');
				
				
				
				$this->excel->getActiveSheet()->mergeCells("B15:C15");
				$this->excel->getActiveSheet()->getStyle('B15')->getAlignment()->applyFromArray(
    array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,)
);
				
				$this->excel->getActiveSheet()->getStyle('C7')->getFont()->getColor()->setRGB('3498db');
				$this->excel->getActiveSheet()->getStyle('C8')->getFont()->getColor()->setRGB('3498db');
				$this->excel->getActiveSheet()->getStyle('C9')->getFont()->getColor()->setRGB('3498db');
				$this->excel->getActiveSheet()->getStyle('C10')->getFont()->getColor()->setRGB('3498db');
				$this->excel->getActiveSheet()->getStyle('C11')->getFont()->getColor()->setRGB('3498db');
					
				
				$this->excel->getActiveSheet()->getStyle('G9')->getFont()->getColor()->setRGB('3498db');
				$this->excel->getActiveSheet()->getStyle('G10')->getFont()->getColor()->setRGB('3498db');
				$this->excel->getActiveSheet()->getStyle('G11')->getFont()->getColor()->setRGB('3498db');
				
				
				
				
                                
				
				
				
				
                $this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(10);
                $this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(10);
                $this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(12);
                $this->excel->getActiveSheet()->getColumnDimension('D')->setWidth(15);
                $this->excel->getActiveSheet()->getColumnDimension('E')->setWidth(15);
                $this->excel->getActiveSheet()->getColumnDimension('F')->setWidth(15);
                $this->excel->getActiveSheet()->getColumnDimension('G')->setWidth(10);
				$this->excel->getActiveSheet()->getColumnDimension('H')->setWidth(10);
                $filename = lang('payment_schedule');
                $this->excel->getDefaultStyle()->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                if ($pdf) {
                    $styleArray = array(
                        'borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN))
                    );
                    $this->excel->getDefaultStyle()->applyFromArray($styleArray);
                    $this->excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
                    require_once(APPPATH . "third_party" . DIRECTORY_SEPARATOR . "MPDF" . DIRECTORY_SEPARATOR . "mpdf.php");
                    $rendererName = PHPExcel_Settings::PDF_RENDERER_MPDF;
                    $rendererLibrary = 'MPDF';
                    $rendererLibraryPath = APPPATH . 'third_party' . DIRECTORY_SEPARATOR . $rendererLibrary;
                    if (!PHPExcel_Settings::setPdfRenderer($rendererName, $rendererLibraryPath)) {
                        die('Please set the $rendererName: ' . $rendererName . ' and $rendererLibraryPath: ' . $rendererLibraryPath . ' values' .
                            PHP_EOL . ' as appropriate for your directory structure');
                    }

                    header('Content-Type: application/pdf');
                    header('Content-Disposition: attachment;filename="' . $filename . '.pdf"');
                    header('Cache-Control: max-age=0');

                    $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'PDF');
                    $objWriter->save('php://output');
                    exit();
                }
                if ($excel) {
                    ob_clean();
                    header('Content-Type: application/vnd.ms-excel');
                    header('Content-Disposition: attachment;filename="' . $filename . '.xls"');
                    header('Cache-Control: max-age=0');
                    ob_clean();
                    $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
                    $objWriter->save('php://output');
                    exit();
                }

            }

            $this->session->set_flashdata('error', lang('nothing_found'));
            redirect($_SERVER["HTTP_REFERER"]);

        }
    }
	
	//################ House #################//
    function house_calendar($warehouse_id = NULL){ 
        $this->load->model('reports_model');
        $this->data['warehouse_id'] = $warehouse_id;
        $this->data['users'] = $this->reports_model->getStaff();
        $this->data['warehouses'] = $this->site->getAllWarehouses();
        $this->data['billers'] = $this->site->getAllCompanies('biller');
        $this->data['error'] = validation_errors() ? validation_errors() : $this->session->flashdata('error');
        $bc = array(array('link' => base_url(), 'page' => lang('home')), array('link' => site_url('sales'), 'page' => lang('sales')), array('link' => '#', 'page' => lang('suspend_calendar')));
        $meta = array('page_title' => lang('suspend_calendar'), 'bc' => $bc);
        $this->page_construct('sales/house_calendar', $meta, $this->data);
    }

    function getHouse_calendar()
    {
        $this->erp->checkPermissions('index');

        $this->load->library('datatables');
        $payments_link = anchor('customers/view/$1', '<i class="fa fa-money"></i> ' . lang('customer_details'), 'data-toggle="modal" data-target="#myModal"');

        $this->datatables
            ->select("products.id as id, products.name, sales.customer as customer_name, 
					COALESCE(erp_sales.grand_total, 0) as price, 
					COALESCE((SELECT amount FROM erp_payments WHERE erp_payments.sale_id = erp_sales.id AND erp_payments.paid_by = 'depreciation'), 0) as deposite, 
					note, (SELECT MIN(dateline) FROM erp_loans WHERE sale_id = erp_sales.id) as start_date, 
					(SELECT MAX(dateline) FROM erp_loans WHERE sale_id = erp_sales.id) as end_date, 
					CONCAT(erp_sales.term, ' Months') as term, 
					CASE WHEN erp_products.id = erp_sale_items.product_id THEN 'sold' ELSE 'aval' END AS status, sales.attachment as attachment")
            ->join('sale_items', 'sale_items.product_id = products.id', 'left')
            ->join('sales', 'sales.id = sale_items.sale_id', 'left')
            ->join('companies', 'companies.id = sales.customer_id', 'left')
            ->from("products")
            ->add_column("Actions", '<center>
                    <div class="btn-group text-left">'
            . '<button type="button" class="btn btn-default btn-xs btn-primary dropdown-toggle" data-toggle="dropdown">'
            . lang('actions') . ' <span class="caret"></span></button>
        <ul class="dropdown-menu pull-right" role="menu">
            <li>' . $payments_link . '</li>
        </ul>
        </div>
                    </center>', "id");
        echo $this->datatables->generate();
    }
	
    //+++++++++++++ Suspends +++++++++++++//
    function house_sales($warehouse_id = NULL){
        $this->load->model('reports_model');
        $this->data['warehouse_id'] = $warehouse_id;
        $this->data['users'] = $this->reports_model->getStaff();
        $this->data['warehouses'] = $this->site->getAllWarehouses();
        $this->data['billers'] = $this->site->getAllCompanies('biller');
        $this->data['error'] = validation_errors() ? validation_errors() : $this->session->flashdata('error');
        $bc = array(array('link' => base_url(), 'page' => lang('home')), array('link' => site_url('sales'), 'page' => lang('sales')), array('link' => '#', 'page' => lang('list_sales_suspend')));
        $meta = array('page_title' => lang('list_sales_suspend'), 'bc' => $bc);
        $this->page_construct('sales/house_sales', $meta, $this->data);
    }

    function getHouseSale($warehouse_id = NULL){
        
        $this->erp->checkPermissions('index');  
        
        if ($this->input->get('user')) {
            $user_query = $this->input->get('user');
        } else {
            $user_query = NULL;
        }
        if ($this->input->get('reference_no')) {
            $reference_no = $this->input->get('reference_no');
        } else {
            $reference_no = NULL;
        }
        if ($this->input->get('customer')) {
            $customer = $this->input->get('customer');
        } else {
            $customer = NULL;
        }
        if ($this->input->get('biller')) {
            $biller = $this->input->get('biller');
        } else {
            $biller = NULL;
        }
        if ($this->input->get('warehouse')) {
            $warehouse = $this->input->get('warehouse');
        } else {
            $warehouse = NULL;
        }
        if ($this->input->get('start_date')) {
            $start_date = $this->input->get('start_date');
        } else {
            $start_date = NULL;
        }
        if ($this->input->get('end_date')) {
            $end_date = $this->input->get('end_date');
        } else {
            $end_date = NULL;
        }
        if ($start_date) {
            $start_date = $this->erp->fld($start_date);
            $end_date = $this->erp->fld($end_date);
        }

        if ((! $this->Owner || ! $this->Admin) && ! $warehouse_id) {
            $user = $this->site->getUser();
            $warehouse_id = $user->warehouse_id;
        }
        
        $add_payment_link = anchor('sales/loan_view/$1', '<i class="fa fa-money"></i> ' . lang('add_payment'), 'data-toggle="modal" data-target="#myModal"');  
        $transfer_link = anchor('sales/transfer_owner/$1', '<i class="fa fa-exchange"></i> ' . lang('transfer_owner'), 'data-toggle="modal" data-target="#myModal"');
		
        $action = '<div class="text-center"><div class="btn-group text-left">'
					. '<button type="button" class="btn btn-default btn-xs btn-primary dropdown-toggle" data-toggle="dropdown">'
						. lang('actions') . ' <span class="caret"></span></button>
						<ul class="dropdown-menu pull-right" role="menu">            
							<li>' . $add_payment_link . '</li>
							<li>' . $transfer_link . '</li>
						</ul>
				</div></div>';       

        $this->load->library('datatables');
        if($warehouse_id){
            $this->datatables
                ->select($this->db->dbprefix('sales').".id as idd,".$this->db->dbprefix('sales').".date, ".$this->db->dbprefix('sales').".suspend_note as suspend, (select phone from ".$this->db->dbprefix('companies')." where id= ".$this->db->dbprefix('sales').".customer_id) as tel,
                    ".$this->db->dbprefix('sales').".customer,  
                    ".$this->db->dbprefix('sales').".sale_status as sale_status,
                    ".$this->db->dbprefix('sales').".grand_total as grand_total, 
                    ".$this->db->dbprefix('sales').".paid as paid, (CASE WHEN ".$this->db->dbprefix('sales').".paid IS NULL THEN ".$this->db->dbprefix('sales').".grand_total ELSE ".$this->db->dbprefix('sales').".grand_total - ".$this->db->dbprefix('sales').".paid END) as balance, CASE WHEN ".$this->db->dbprefix('sales').".paid = 0 THEN 'pending' WHEN ".$this->db->dbprefix('sales').".grand_total = ".$this->db->dbprefix('sales').".paid THEN 'completed' WHEN ".$this->db->dbprefix('sales').".grand_total > ".$this->db->dbprefix('sales').".paid THEN 'partial' ELSE 'pending' END as payment_status")
                ->join($this->db->dbprefix('loans'), $this->db->dbprefix('sales').'.id = '.$this->db->dbprefix('loans').'.sale_id', 'right')
                ->from('sales')
                ->where($this->db->dbprefix('sales').'.warehouse_id', $warehouse_id);
        }else{
            $this->datatables
                ->select($this->db->dbprefix('sales').".id as idd,".$this->db->dbprefix('sales').".date, "
                    .$this->db->dbprefix('sale_items').".product_name as suspend,"
                    .$this->db->dbprefix('sales').".customer,
                    (select phone from ".$this->db->dbprefix('companies')." where id= ".$this->db->dbprefix('sales').".customer_id) as tel,  
                    ".$this->db->dbprefix('sales').".sale_status as sale_status,
                    ".$this->db->dbprefix('sales').".grand_total as grand_total, 
                    ".$this->db->dbprefix('sales').".paid as paid, (CASE WHEN ".$this->db->dbprefix('sales').".paid IS NULL THEN ".$this->db->dbprefix('sales').".grand_total ELSE ".$this->db->dbprefix('sales').".grand_total - ".$this->db->dbprefix('sales').".paid END) as balance, ".$this->db->dbprefix('sales').".payment_status as payment_status")
                ->join($this->db->dbprefix('loans'), $this->db->dbprefix('sales').'.id = '.$this->db->dbprefix('loans').'.sale_id', 'right')
                ->join($this->db->dbprefix('sale_items'), $this->db->dbprefix('sales').'.id = '.$this->db->dbprefix('sale_items').'.sale_id', 'right')
				->group_by('sales.id')
                ->from('sales');
        }       
        if (!$this->Customer && !$this->Supplier && !$this->Owner && !$this->Admin) {
            $this->datatables->where('created_by', $this->session->userdata('user_id'));
        } elseif ($this->Customer) {
            $this->datatables->where('customer_id', $this->session->userdata('user_id'));
        }
        
        if ($user_query) {
            $this->datatables->where('suspended_bills.created_by', $user_query);
        }
        if ($reference_no) {
            $this->datatables->where('suspended_bills.suspend_name', $reference_no);
        }
        if ($biller) {
            $this->datatables->where('suspended_bills.biller_id', $biller);
        }
        if ($customer) {
            $this->datatables->where('suspended_bills.customer_id', $customer);
        }
        if ($warehouse) {
            $this->datatables->where('suspended_bills.warehouse_id', $warehouse);
        }

        if ($start_date || $end_date) {
            $this->datatables->where($this->db->dbprefix('suspended_bills').'.date >= "' . $start_date . '" AND ' . $this->db->dbprefix('suspended_bills').'.date < "' . $end_date . '"');
        }

        $this->datatables->add_column("Actions", $action, "idd");
        echo $this->datatables->generate();  
    }
	
	//********************* Transfer Owner *************************/
	//********************* Transfer Owner *************************/
	function transfer_owner($id){
		$this->data['id'] = $id;
		$this->data['modal_js'] = $this->site->modal_js();
		$this->data['transfer_owner'] = $this->sales_model->getTransferOwner($id);
		//$this->erp->print_arrays($transfer['transfer_owner']);
		$this->load->view($this->theme.'sales/modal_transfer', $this->data);
	}
	function trasfer_submit($id){
		$customer = $this->input->post('customer');
		$charge_amount = $this->input->post('charge_amount');
		$curDate = $this->input->post('transfer_date');
		$detail   = $this->sales_model->getCustomerByID($customer);
		$sales   = $this->sales_model->getSalesById($id);
		$getCustomerPaid = $this->sales_model->getCustomerPaid($sales->id, $sales->customer_id);
		//$this->erp->print_arrays($getCustomerPaid->paid);
		$data = array(
			'customer_id' => $detail->id,
			'customer'    => $detail->name,
			'transfer_charge' => $charge_amount,
			'old_customer' => $sales->customer,
			'transfer_date' => $curDate
		);
		$transfer_data = array(
			'date' => $curDate,
			'sale_id' => $sales->id,
			'old_customer' => $sales->customer_id,
			'new_customer' => $detail->id,
			'grand_total' => $sales->grand_total,
			'paid' => $getCustomerPaid->paid,
			'transfer_charge' => $charge_amount,
			'created_by' => $this->session->userdata('user_id'),
			'created_date' => $this->erp->fld(date("d/m/Y h:i"))
		);
		//$this->erp->print_arrays($transfer_data);
		$update   = $this->sales_model->updateSales($id, $data);
		if($update) {
			$this->sales_model->addCustomerTransfer($transfer_data);
		}
		redirect($_SERVER["HTTP_REFERER"]);
	}
	
	function getProductVariant(){
		$product_id = $this->input->get('pro_id');
		$product_variant = $this->sales_model->getProductVariantByid($product_id);
		echo json_encode($product_variant);
	}
	
	function getProductVariantOptionAndID(){
		$product_id = $this->input->get('product_id');
		$product_option = $this->input->get('option_id');
		$productVariants = $this->sales_model->getIndividualVariant($product_id,$product_option);
		if($productVariants){
			echo json_encode($productVariants);
		}
		return Null;
	}
	function getPartialAmount(){
		$sale_order_id = $this->input->get('sale_order_id');
		$partial_amount = $this->sales_model->get_partialAmount($sale_order_id);
		if($partial_amount != 0 && $partial_amount != "" && $partial_amount != Null){
			echo json_encode($partial_amount);
		}
		return false;
		
	}
	
	function getPaidAmountBySaleOrderId($sale_order_id=Null){
		$sale_order_id = $this->input->get('sale_order_id');
		$paid_amount = $this->sales_model->get_paidAmount($sale_order_id);
		if($paid_amount != 0 && $paid_amount != "" && $paid_amount != Null){
			echo json_encode($paid_amount);
		}
		return false;
		
	}
	
	public function checkrefer(){
		if($this->input->get('items')){
			$items=$this->input->get('items');
		}else{
			$items = '';
		}
		
		if(is_array($items)){
			$isAuth = 0;
			$first = 1;
			$status = "";
			for($i=0;$i<sizeof($items);$i++){
				$id = $items[$i]['delivery_id'];
				$data=$this->sales_model->checkrefer($id);
				$new_data = $data->sale_reference_no;
				if($first == 1){
					$str_old = $new_data;
				}
				//$old_data = explode('/',$str_old);
				//$new_data = explode('/',$new_data);
				if($str_old != $new_data){
					$isAuth = 1;
				}
				$first++;
				if($data->sale_status == "completed"){
					$status = 2;
				}
			}
			echo json_encode(array('isAuth'=>$isAuth,'status'=>$status));
			exit();
		}
		echo json_encode(2);
	}
	function invoice_devery($id)
    {
		$this->erp->checkPermissions();
		$this->data['invs'] = $this->sales_model->getSaleByDeliveryID($id);
		$this->data['bill'] = $this->sales_model->getSaleByDeliveryIDBill($id);
		$this->data['ref'] = $this->sales_model->getDeliveryRefIDBill($id);
		$this->data['rows'] = $this->sales_model->getAllSaleByDeliveryID($id);
        $bc = array(array('link' => base_url(), 'page' => lang('home')), array('link' => '#', 'page' => lang('invoice_devery')));
        $meta = array('page_title' => lang('invoice_devery'), 'bc' => $bc);
        $this->page_construct('sales/invoice_devery', $meta, $this->data);
    }
	function print_invoice($id)
    {
		$this->erp->checkPermissions();
		$this->data['invs'] = $this->sales_model->getSaleByDeliveryID($id);
		$this->data['bill'] = $this->sales_model->getSaleByDeliveryIDBill($id);
		$this->data['rows'] = $this->sales_model->getAllSaleItemID($id);
        $bc = array(array('link' => base_url(), 'page' => lang('home')), array('link' => '#', 'page' => lang('invoice_devery')));
        $meta = array('page_title' => lang('invoice_devery'), 'bc' => $bc);
        $this->page_construct('sales/print_invoice', $meta, $this->data);
    }
}
