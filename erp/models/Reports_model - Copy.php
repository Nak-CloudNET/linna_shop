<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Reports_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function getProductNames($term, $limit = 5)
    {
        $this->db->select('id, code, name')
            ->like('name', $term, 'both')->or_like('code', $term, 'both');
        $this->db->limit($limit);
        $q = $this->db->get('products');
        if ($q->num_rows() > 0) {
            foreach (($q->result()) as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return FALSE;
    }

    public function getStaff()
    {
        if ($this->Admin) {
            $this->db->where('group_id !=', 1);
        }
        $this->db->where('group_id !=', 3)->where('group_id !=', 4);
        $q = $this->db->get('users');
        if ($q->num_rows() > 0) {
            foreach (($q->result()) as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return FALSE;
    }

    public function getSalesTotals($customer_id)
    {

        $this->db->select('SUM(COALESCE(grand_total, 0)) as total_amount, SUM(COALESCE(paid, 0)) as paid', FALSE)
            ->where('biller_id', $customer_id);
        $q = $this->db->get('sales');
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return FALSE;
    }

    public function getCustomerSales($customer_id)
    {
        $this->db->from('sales')->where('biller_id', $customer_id);
        return $this->db->count_all_results();
    }

    public function getCustomerQuotes($customer_id)
    {
        $this->db->from('quotes')->where('biller_id', $customer_id);
        return $this->db->count_all_results();
    }

    public function getCustomerReturns($customer_id)
    {
        $this->db->from('return_sales')->where('biller_id', $customer_id);
        return $this->db->count_all_results();
    }
	
	public function getCustomerDeposits($company_id)
    {
        $this->db
                ->from('deposits')
                ->join('users', 'users.id=deposits.created_by', 'left')
				->where($this->db->dbprefix('deposits') . ".company_id", $company_id);
        return $this->db->count_all_results();
    }

    public function getStockValue()
    {
        $q = $this->db->query("SELECT SUM(by_price) as stock_by_price, SUM(by_cost) as stock_by_cost FROM ( Select COALESCE(sum(" . $this->db->dbprefix('warehouses_products') . ".quantity), 0)*price as by_price, COALESCE(sum(" . $this->db->dbprefix('warehouses_products') . ".quantity), 0)*cost as by_cost FROM " . $this->db->dbprefix('products') . " JOIN " . $this->db->dbprefix('warehouses_products') . " ON " . $this->db->dbprefix('warehouses_products') . ".product_id=" . $this->db->dbprefix('products') . ".id GROUP BY " . $this->db->dbprefix('products') . ".id )a");
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return FALSE;
    }
	 public function getWarehouseStockValue($id)
    {
        $q = $this->db->query("SELECT SUM(by_price) as stock_by_price, SUM(by_cost) as stock_by_cost FROM ( Select sum(COALESCE(" . $this->db->dbprefix('warehouses_products') . ".quantity, 0))*price as by_price, sum(COALESCE(" . $this->db->dbprefix('warehouses_products') . ".quantity, 0))*cost as by_cost FROM " . $this->db->dbprefix('products') . " JOIN " . $this->db->dbprefix('warehouses_products') . " ON " . $this->db->dbprefix('warehouses_products') . ".product_id=" . $this->db->dbprefix('products') . ".id WHERE " . $this->db->dbprefix('warehouses_products') . ".warehouse_id = ? GROUP BY " . $this->db->dbprefix('products') . ".id )a", array($id));
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return FALSE;
    }
	
	//chivorn chart stock
	
		
	public function getCategoryStockValue($biller= NULL,$customer= NULL,$start_date= NULL,$end_date= NULL)
    {
		if($biller != NULL){
			$where_biller = " AND erp_sales.biller_id=".$biller;
		}else{
			$where_biller = "";
		}
		if($customer != NULL){
			$where_customer = " AND erp_sales.customer_id=".$customer;
		}else{
			$where_customer = "";
		}
		if($start_date != NULL && $end_date != NULL){
			$where_between_date = " AND erp_sales.date between '$start_date' AND '$end_date'";
		}else{
			$where_between_date = "";
		}
		
		$q = $this->db->query("
			SELECT
				COALESCE (
					sum(
						erp_sale_items.subtotal
					),
					0
				) AS by_price,
				erp_categories.name AS category_name
			FROM
				erp_products
			JOIN erp_warehouses_products ON erp_warehouses_products.product_id = erp_products.id
			JOIN erp_categories ON erp_categories.id = erp_products.category_id
			JOIN erp_sale_items ON erp_sale_items.product_id = erp_products.id
			JOIN erp_sales ON erp_sales.id = erp_sale_items.sale_id WHERE 1=1 $where_biller $where_customer $where_between_date
			GROUP BY
				erp_categories.id");
        
        if ($q->num_rows() > 0) {
            return $q->result();
        }
        return FALSE;
    }
	public function getChartValue()
    {
		$q = $this->db->query("
			SELECT
				accountcode,
				accountname,
				COALESCE (
					sum(
						amount
					),
					0
				) AS total_amount
			FROM
				erp_gl_charts
			LEFT JOIN erp_gl_trans ON erp_gl_trans.account_code = erp_gl_charts.accountcode
			WHERE
				erp_gl_charts.bank = 1
			GROUP BY
				accountcode;");
        
        if ($q->num_rows() > 0) {
            return $q->result();
        }
        return FALSE;
    }
	public function getCategoryStockValueById($id, $biller= NULL,$customer= NULL,$start_date= NULL,$end_date= NULL)
    {
		if($biller != NULL){
			$where_biller = " AND erp_sales.biller_id=".$biller;
		}else{
			$where_biller = "";
		}
		if($customer != NULL){
			$where_customer = " AND erp_sales.customer_id=".$customer;
		}else{
			$where_customer = "";
		}
		
		if($start_date != NULL && $end_date != NULL){
			$where_between_date = " AND erp_sales.date between '$start_date' AND '$end_date'";
		}else{
			$where_between_date = "";
		}
		
        $q = $this->db->query("
			SELECT
				COALESCE (
					sum(
						erp_sale_items.subtotal
					),
					0
				) AS by_price,
				erp_categories.name AS category_name
			FROM
				erp_products
			JOIN erp_warehouses_products ON erp_warehouses_products.product_id = erp_products.id
			JOIN erp_categories ON erp_categories.id = erp_products.category_id
			JOIN erp_sale_items ON erp_sale_items.product_id = erp_products.id
			JOIN erp_sales ON erp_sales.id = erp_sale_items.sale_id
			WHERE erp_sale_items.warehouse_id = $id $where_biller $where_customer $where_between_date
			GROUP BY
				erp_categories.id");
        
        if ($q->num_rows() > 0) {
            return $q->result();
        }
        return FALSE;
    }
	public function getChartValueById($id)
    {
        $q = $this->db->query("
SELECT
				accountcode,
				accountname,
				COALESCE (
					sum(
						amount
					),
					0
				) AS total_amount
			FROM
				erp_gl_charts
			LEFT JOIN erp_gl_trans ON erp_gl_trans.account_code = erp_gl_charts.accountcode
			WHERE
				erp_gl_charts.bank = 1 and erp_gl_trans.account_code= $id
			GROUP BY
				accountcode;");
        
        if ($q->num_rows() > 0) {
            return $q->result();
        }
        return FALSE;
    }
	public function getChartDataProfit($biller_id = null, $year = null)
    {
	if($biller_id != null){
		$where_biller_id = "AND erp_gl_trans.biller_id = ".$biller_id;
	}else{
		$where_biller_id = "";
	}
	if($year != null){
		$where_year = "AND YEAR(erp_gl_trans.tran_date) = ".$year;
	}else{
		$where_year = "";
	}
        $myQuery = "SELECT
	I. MONTH,
	COALESCE (I.income, 0) AS income,
	COALESCE (C.cost, 0) AS cost,
	COALESCE (O.operation, 0) AS operation
FROM
	(
		SELECT
			date_format(tran_date, '%Y-%m') MONTH,
			erp_gl_trans.account_code,
			erp_gl_trans.sectionid,
			erp_gl_charts.accountname,
			erp_gl_charts.parent_acc,
			sum(erp_gl_trans.amount) AS income
		FROM
			erp_gl_trans
		INNER JOIN erp_gl_charts ON erp_gl_charts.accountcode = erp_gl_trans.account_code
		WHERE
			erp_gl_trans.tran_date >= date_sub(now(), INTERVAL 12 MONTH)
		AND erp_gl_trans.sectionid IN (40, 70) $where_biller_id $where_year
	
			GROUP BY date_format(tran_date, '%Y-%m'),
			erp_gl_trans.account_code
	) I
LEFT JOIN (
	SELECT
		date_format(tran_date, '%Y-%m') MONTH,
		erp_gl_trans.account_code,
		erp_gl_trans.sectionid,
		erp_gl_charts.accountname,
		erp_gl_charts.parent_acc,
		sum(erp_gl_trans.amount) AS cost
	FROM
		erp_gl_trans
	INNER JOIN erp_gl_charts ON erp_gl_charts.accountcode = erp_gl_trans.account_code
	WHERE
		erp_gl_trans.tran_date >= date_sub(now(), INTERVAL 12 MONTH)
	AND erp_gl_trans.sectionid IN (50) $where_biller_id $where_year

		GROUP BY date_format(tran_date, '%Y-%m'),
		erp_gl_trans.account_code
) C ON I. MONTH = C. MONTH
LEFT JOIN (
	SELECT
		date_format(tran_date, '%Y-%m') MONTH,
		erp_gl_trans.account_code,
		erp_gl_trans.sectionid,
		erp_gl_charts.accountname,
		erp_gl_charts.parent_acc,
		sum(erp_gl_trans.amount) AS operation
	FROM
		erp_gl_trans
	INNER JOIN erp_gl_charts ON erp_gl_charts.accountcode = erp_gl_trans.account_code
	WHERE
		erp_gl_trans.tran_date >= date_sub(now(), INTERVAL 12 MONTH)
	AND erp_gl_trans.sectionid IN (60,80,90) $where_biller_id $where_year
		GROUP BY date_format(tran_date, '%Y-%m'),
		erp_gl_trans.account_code
) O ON O. MONTH = I. MONTH
GROUP BY
	I. MONTH
ORDER BY
	I. MONTH";
        $q = $this->db->query($myQuery);
        if ($q->num_rows() > 0) {
            foreach (($q->result()) as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return FALSE;
    }
	// end chivorn
	
    public function getChartData()
    {
        $myQuery = "SELECT S.month,
        COALESCE(S.sales, 0) as sales,
        COALESCE( P.purchases, 0 ) as purchases,
        COALESCE(S.tax1, 0) as tax1,
        COALESCE(S.tax2, 0) as tax2,
        COALESCE( P.ptax, 0 ) as ptax
        FROM (  SELECT  date_format(date, '%Y-%m') Month,
                SUM(total) Sales,
                SUM(product_tax) tax1,
                SUM(order_tax) tax2
                FROM " . $this->db->dbprefix('sales') . "
                WHERE date >= date_sub( now( ) , INTERVAL 12 MONTH )
                GROUP BY date_format(date, '%Y-%m')) S
            LEFT JOIN ( SELECT  date_format(date, '%Y-%m') Month,
                        SUM(product_tax) ptax,
                        SUM(order_tax) otax,
                        SUM(total) purchases
                        FROM " . $this->db->dbprefix('purchases') . "
                        GROUP BY date_format(date, '%Y-%m')) P
            ON S.Month = P.Month
            GROUP BY S.Month
            ORDER BY S.Month";
        $q = $this->db->query($myQuery);
        if ($q->num_rows() > 0) {
            foreach (($q->result()) as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return FALSE;
    }

    public function getAllWarehouses()
    {
        $q = $this->db->get('warehouses');
        if ($q->num_rows() > 0) {
            foreach (($q->result()) as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return FALSE;
    }
	
	public function getAllSaleIemsWarehouses()
    {
        $this->db
			->select('warehouses.code')
            ->from('warehouses')
			->join('sale_items', 'warehouses.id = sale_items.warehouse_id')
			->group_by('sale_items.warehouse_id');
		$q = $this->db->get();
        if ($q->num_rows() > 0) {
            foreach (($q->result()) as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return FALSE;
    }
	
	 public function getAllCharts()
    {
        $q = $this->db->get('gl_charts');
        if ($q->num_rows() > 0) {
            foreach (($q->result()) as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return FALSE;
    }

    public function getAllCustomers()
    {
        $q = $this->db->get('customers');
        if ($q->num_rows() > 0) {
            foreach (($q->result()) as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return FALSE;
    }

    public function getAllBillers()
    {
        $q = $this->db->get('billers');
        if ($q->num_rows() > 0) {
            foreach (($q->result()) as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return FALSE;
    }

    public function getAllSuppliers()
    {
        $q = $this->db->get('suppliers');
        if ($q->num_rows() > 0) {
            foreach (($q->result()) as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return FALSE;
    }
    
    public function getDailySales($year, $month)
    {
        $myQuery = "SELECT DATE_FORMAT( date,  '%e' ) AS date, 
		SUM( COALESCE( product_tax, 0 ) ) AS tax1, 
		SUM( COALESCE( order_tax, 0 ) ) AS tax2, 
		SUM( COALESCE( total, 0 ) ) AS total, 
		SUM( COALESCE( total_discount, 0 ) ) AS discount, 
		SUM( COALESCE( order_discount, 0 ) ) AS order_discount, 
		SUM( COALESCE( shipping, 0 ) ) AS shipping
			FROM " . $this->db->dbprefix('sales') . "
			WHERE DATE_FORMAT( date,  '%Y-%m' ) =  '{$year}-{$month}'
			GROUP BY DATE_FORMAT( date,  '%e' )";
        $q = $this->db->query($myQuery, false);
        if ($q->num_rows() > 0) {
            foreach (($q->result()) as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return FALSE;
    }

    public function getMonthlySales($year)
    {
        $myQuery = "SELECT DATE_FORMAT( date,  '%c' ) AS date,
		SUM( COALESCE( product_tax, 0 ) ) AS tax1, 
		SUM( COALESCE( order_tax, 0 ) ) AS tax2, 
		SUM( COALESCE( total, 0 ) ) AS total,
		SUM( COALESCE( total_discount, 0 ) ) AS discount,
		SUM( COALESCE( order_discount, 0 ) ) AS order_discount, 
		SUM( COALESCE( shipping, 0 ) ) AS shipping
			FROM " . $this->db->dbprefix('sales') . "
			WHERE DATE_FORMAT( date,  '%Y' ) =  '{$year}'
			GROUP BY date_format( date, '%c' ) ORDER BY date_format( date, '%c' ) ASC";
        $q = $this->db->query($myQuery, false);
        if ($q->num_rows() > 0) {
            foreach (($q->result()) as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return FALSE;
    }

    public function getRoomDailySales($room_id, $year, $month)
    {
        $myQuery = "SELECT DATE_FORMAT( date,  '%e' ) AS date, SUM( COALESCE( product_tax, 0 ) ) AS tax1, SUM( COALESCE( order_tax, 0 ) ) AS tax2, SUM( COALESCE( grand_total, 0 ) ) AS total, SUM( COALESCE( total_discount, 0 ) ) AS discount, SUM( COALESCE( shipping, 0 ) ) AS shipping
            FROM " . $this->db->dbprefix('sales') . "
            WHERE suspend_note = {$room_id} AND DATE_FORMAT( date,  '%Y-%m' ) =  '{$year}-{$month}'
            GROUP BY DATE_FORMAT( date,  '%e' )";
        $q = $this->db->query($myQuery, false);
        if ($q->num_rows() > 0) {
            foreach (($q->result()) as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return FALSE;
    }
	
	public function getStaffDailySaleman($user_id, $year, $month)
    {
        $myQuery = "SELECT DATE_FORMAT( date,  '%e' ) AS date, SUM( COALESCE( product_tax, 0 ) ) AS tax1, SUM( COALESCE( order_tax, 0 ) ) AS tax2, SUM( COALESCE( grand_total, 0 ) ) AS total, SUM( COALESCE( total_discount, 0 ) ) AS discount, SUM( COALESCE( shipping, 0 ) ) AS shipping
            FROM " . $this->db->dbprefix('sales') . "
            WHERE (CASE WHEN saleman_by <> '' THEN saleman_by ELSE created_by END) = {$user_id} AND DATE_FORMAT( date,  '%Y-%m' ) =  '{$year}-{$month}'
            GROUP BY DATE_FORMAT( date,  '%e' )";
        $q = $this->db->query($myQuery, false);
        if ($q->num_rows() > 0) {
            foreach (($q->result()) as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return FALSE;
    }
	
    public function getStaffDailySales($user_id, $year, $month)
    {
        $myQuery = "SELECT DATE_FORMAT( date,  '%e' ) AS date, SUM( COALESCE( product_tax, 0 ) ) AS tax1, 
			SUM( COALESCE( order_tax, 0 ) ) AS tax2, 
			SUM( COALESCE( total, 0 ) ) AS total,
			SUM( COALESCE( total_discount, 0 ) ) AS discount,
			SUM( COALESCE( order_discount, 0 ) ) AS order_discount, 
			SUM( COALESCE( shipping, 0 ) ) AS shipping
            FROM " . $this->db->dbprefix('sales') . "
            WHERE created_by = {$user_id} AND DATE_FORMAT( date,  '%Y-%m' ) =  '{$year}-{$month}'
            GROUP BY DATE_FORMAT( date,  '%e' )";
        $q = $this->db->query($myQuery, false);
        if ($q->num_rows() > 0) {
            foreach (($q->result()) as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return FALSE;
    }

    public function getProjectManagerDailySales($user_id, $year, $month)
    {
        $myQuery = "SELECT DATE_FORMAT( date,  '%e' ) AS date, SUM( COALESCE( product_tax, 0 ) ) AS tax1, SUM( COALESCE( order_tax, 0 ) ) AS tax2, SUM( COALESCE( grand_total, 0 ) ) AS total,  SUM( COALESCE( subtotal, 0 ) ) AS subtotal, SUM( COALESCE( total_discount, 0 ) ) AS discount,SUM( COALESCE( order_discount, 0 ) ) AS order_discount, SUM( COALESCE( shipping, 0 ) ) AS shipping
            FROM " . $this->db->dbprefix('sales') . "
            LEFT JOIN " . $this->db->dbprefix('sale_items') . " as sale_items ON sale_items.sale_id = " . $this->db->dbprefix('sales') . ".id
            LEFT JOIN " . $this->db->dbprefix('users') . " as users ON users.id = " . $this->db->dbprefix('sales') . ".assign_to_id
            WHERE users.id = {$user_id} AND DATE_FORMAT( date,  '%Y-%m' ) =  '{$year}-{$month}'
            GROUP BY DATE_FORMAT( date,  '%e' )";
        $q = $this->db->query($myQuery, false);
        if ($q->num_rows() > 0) {
            foreach (($q->result()) as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return FALSE;
    }

    public function getRoomMonthlySales($room_id, $year)
    {
        $myQuery = "SELECT DATE_FORMAT( date,  '%c' ) AS date, SUM( COALESCE( product_tax, 0 ) ) AS tax1, SUM( COALESCE( order_tax, 0 ) ) AS tax2, SUM( COALESCE( grand_total, 0 ) ) AS total, SUM( COALESCE( total_discount, 0 ) ) AS discount, SUM( COALESCE( shipping, 0 ) ) AS shipping
            FROM " . $this->db->dbprefix('sales') . "
            WHERE suspend_note = {$room_id} AND DATE_FORMAT( date,  '%Y' ) =  '{$year}'
            GROUP BY date_format( date, '%c' ) ORDER BY date_format( date, '%c' ) ASC";
        $q = $this->db->query($myQuery, false);
        if ($q->num_rows() > 0) {
            foreach (($q->result()) as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return FALSE;
    }
	
	public function getStaffMonthlySaleman($user_id, $year)
    {
        $myQuery = "SELECT DATE_FORMAT( date,  '%c' ) AS date, 
		SUM( COALESCE( product_tax, 0 ) ) AS tax1, 
		SUM( COALESCE( order_tax, 0 ) ) AS tax2, 
		SUM( COALESCE( total, 0 ) ) AS total,
		SUM( COALESCE( total_discount, 0 ) ) AS discount, 
		SUM( COALESCE( order_discount, 0 ) ) AS order_discount, 
		SUM( COALESCE( shipping, 0 ) ) AS shipping
            FROM " . $this->db->dbprefix('sales') . "
            WHERE (CASE WHEN saleman_by <> '' THEN saleman_by ELSE created_by END) = {$user_id} AND DATE_FORMAT( date,  '%Y' ) =  '{$year}'
            GROUP BY date_format( date, '%c' ) ORDER BY date_format( date, '%c' ) ASC";
        $q = $this->db->query($myQuery, false);
        if ($q->num_rows() > 0) {
            foreach (($q->result()) as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return FALSE;
    }

    public function getMonthlyReportByPM($user_id, $year)
    {
        $myQuery = "SELECT DATE_FORMAT( date,  '%c' ) AS date, SUM( COALESCE( product_tax, 0 ) ) AS tax1, SUM( COALESCE( order_tax, 0 ) ) AS tax2, SUM( COALESCE( grand_total, 0 ) ) AS total, SUM( COALESCE( subtotal, 0 ) ) AS subtotal, SUM( COALESCE( total_discount, 0 ) ) AS discount, SUM( COALESCE( order_discount, 0 ) ) AS order_discount, SUM( COALESCE( shipping, 0 ) ) AS shipping
            FROM " . $this->db->dbprefix('sales') . "
            LEFT JOIN " . $this->db->dbprefix('sale_items') . " as sale_items ON sale_items.sale_id = " . $this->db->dbprefix('sales') . ".id
            LEFT JOIN " . $this->db->dbprefix('users') . " as users ON users.id = " . $this->db->dbprefix('sales') . ".assign_to_id
            WHERE DATE_FORMAT( date,  '%Y' ) =  '{$year}' AND users.id = '{$user_id}'
            GROUP BY date_format( date, '%c' ) ORDER BY date_format( date, '%c' ) ASC";
        $q = $this->db->query($myQuery, false);
        if ($q->num_rows() > 0) {
            foreach (($q->result()) as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return FALSE;
    }

    public function getStaffMonthlySales($user_id, $year)
    {
        $myQuery = "SELECT DATE_FORMAT( date,  '%c' ) AS date, SUM( COALESCE( product_tax, 0 ) ) AS tax1, SUM( COALESCE( order_tax, 0 ) ) AS tax2, SUM( COALESCE( grand_total, 0 ) ) AS total, SUM( COALESCE( total_discount, 0 ) ) AS discount, SUM( COALESCE( shipping, 0 ) ) AS shipping
            FROM " . $this->db->dbprefix('sales') . "
            WHERE created_by = {$user_id} AND DATE_FORMAT( date,  '%Y' ) =  '{$year}'
            GROUP BY date_format( date, '%c' ) ORDER BY date_format( date, '%c' ) ASC";
        $q = $this->db->query($myQuery, false);
        if ($q->num_rows() > 0) {
            foreach (($q->result()) as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return FALSE;
    }

    public function getPurchasesTotals($supplier_id)
    {
        $this->db->select('SUM(COALESCE(grand_total, 0)) as total_amount, SUM(COALESCE(paid, 0)) as paid', FALSE)
            ->where('supplier_id', $supplier_id);
        $q = $this->db->get('purchases');
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return FALSE;
    }

    public function getSupplierPurchases($supplier_id)
    {
        $this->db->from('purchases')->where('supplier_id', $supplier_id);
        return $this->db->count_all_results();
    }


    public function getRoomPurchases($room_id)
    {
        $this->db->select('count(id) as total, SUM(COALESCE(grand_total, 0)) as total_amount, SUM(COALESCE(paid, 0)) as paid', FALSE)
            ->where('suspend_note', $room_id);
        $q = $this->db->get('purchases');
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return FALSE;
    }

    public function getStaffPurchases($user_id)
    {
        $this->db->select('count(id) as total, SUM(COALESCE(grand_total, 0)) as total_amount, SUM(COALESCE(paid, 0)) as paid', FALSE)
            ->where('created_by', $user_id);
        $q = $this->db->get('purchases');
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return FALSE;
    }

    public function getStaffSales($user_id)
    {
        $this->db->select('count(id) as total, SUM(COALESCE(grand_total, 0)) as total_amount, SUM(COALESCE(paid, 0)) as paid', FALSE)
            ->where('created_by', $user_id);
        $q = $this->db->get('saless');
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return FALSE;
    }
    
    public function getStaffSaleman($user_id)
    {
        $this->db->select('count(id) as total, SUM(COALESCE(grand_total, 0)) as total_amount, SUM(COALESCE(paid, 0)) as paid', FALSE)
            ->where('saleman_by', $user_id);
        $q = $this->db->get('sales');
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return FALSE;
    }
	
	
	public function getStaffSalesProject($user_id)
    {
        $this->db->select('count(id) as total, SUM(COALESCE(grand_total, 0)) as total_amount, SUM(COALESCE(paid, 0)) as paid', FALSE)
            ->where('assign_to_id', $user_id);
        $q = $this->db->get('saless');
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return FALSE;
    }
    
    public function getStaffSalemanProject($user_id)
    {
        $this->db->select('count(id) as total, SUM(COALESCE(grand_total, 0)) as total_amount, SUM(COALESCE(paid, 0)) as paid', FALSE)
            ->where('assign_to_id', $user_id);
        $q = $this->db->get('sales');
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return FALSE;
    }

    public function getRoomSales($room_id)
    {
        $this->db->select('count(id) as total, SUM(COALESCE(grand_total, 0)) as total_amount, SUM(COALESCE(paid, 0)) as paid', FALSE)
            ->where('suspend_note', $room_id);
        $q = $this->db->get('sales');
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return FALSE;
    }
    
    public function getTotalSales($start, $end, $biller_id = NULL)
    {
        $this->db->select('count(id) as total, sum(COALESCE(grand_total, 0)) as total_amount, SUM(COALESCE(paid, 0)) as paid, SUM(COALESCE(total_tax, 0)) as tax', FALSE)
            ->where('sale_status !=', 'pending')
            ->where('date BETWEEN ' . $start . ' and ' . $end);
			if($biller_id != NULL){
				$this->db->where('biller_id', $biller_id);
			}
        $q = $this->db->get('sales');
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return FALSE;
    }

    public function getTotalPurchases($start, $end, $biller_id = NULL)
    {
        $this->db->select('count(id) as total, sum(COALESCE(grand_total, 0)) as total_amount, SUM(COALESCE(paid, 0)) as paid, SUM(COALESCE(total_tax, 0)) as tax', FALSE)
            ->where('status', 'received')
			->where('date BETWEEN ' . $start . ' and ' . $end);
			if($biller_id != NULL){
				$this->db->where('biller_id', $biller_id);
			}
        $q = $this->db->get('purchases');
		
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return FALSE;
    }

    public function getTotalExpenses($start, $end, $biller_id = NULL)
    {
        $this->db->select('count(id) as total, sum(COALESCE(amount, 0)) as total_amount', FALSE)
            ->where('date BETWEEN ' . $start . ' and ' . $end);
			if($biller_id != NULL){
				$this->db->where('biller_id', $biller_id);
			}
        $q = $this->db->get('expenses');
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return FALSE;
    }

    public function getTotalPaidAmount($start, $end, $biller_id = NULL)
    {
        $this->db->select('count(id) as total, SUM(COALESCE(amount, 0)) as total_amount', FALSE)
            ->where('type', 'sent')
            ->where('date BETWEEN ' . $start . ' and ' . $end);
			if($biller_id != NULL){
				$this->db->where('biller_id', $biller_id);
			}
        $q = $this->db->get('payments');
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return FALSE;
    }

    public function getTotalReceivedAmount($start, $end, $biller_id = NULL)
    {
        $this->db->select('count(id) as total, SUM(COALESCE(amount, 0)) as total_amount', FALSE)
            ->where('type', 'received')
            ->where('date BETWEEN ' . $start . ' and ' . $end);
			if($biller_id != NULL){
				$this->db->where('biller_id', $biller_id);
			}
        $q = $this->db->get('payments');
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return FALSE;
    }

    public function getTotalReceivedCashAmount($start, $end, $biller_id = NULL)
    {
        $this->db->select('count(id) as total, SUM(COALESCE(amount, 0)) as total_amount', FALSE)
            ->where('type', 'received')->where('paid_by', 'cash')
            ->where('date BETWEEN ' . $start . ' and ' . $end);
			if($biller_id != NULL){
				$this->db->where('biller_id', $biller_id);
			}
        $q = $this->db->get('payments');
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return FALSE;
    }

    public function getTotalReceivedCCAmount($start, $end,$biller_id = NULL)
    {
        $this->db->select('count(id) as total, SUM(COALESCE(amount, 0)) as total_amount', FALSE)
            ->where('type', 'received')->where('paid_by', 'CC')
            ->where('date BETWEEN ' . $start . ' and ' . $end);
			if($biller_id != NULL){
				$this->db->where('biller_id', $biller_id);
			}
        $q = $this->db->get('payments');
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return FALSE;
    }

    public function getTotalReceivedChequeAmount($start, $end, $biller_id = NULL)
    {
        $this->db->select('count(id) as total, SUM(COALESCE(amount, 0)) as total_amount', FALSE)
            ->where('type', 'received')->where('paid_by', 'Cheque')
            ->where('date BETWEEN ' . $start . ' and ' . $end);
			if($biller_id != NULL){
				$this->db->where('biller_id', $biller_id);
			}
        $q = $this->db->get('payments');
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return FALSE;
    }

    public function getTotalReceivedPPPAmount($start, $end, $biller_id = NULL)
    {
        $this->db->select('count(id) as total, SUM(COALESCE(amount, 0)) as total_amount', FALSE)
            ->where('type', 'received')->where('paid_by', 'ppp')
            ->where('date BETWEEN ' . $start . ' and ' . $end);
			if($biller_id != NULL){
				$this->db->where('biller_id', $biller_id);
			}
        $q = $this->db->get('payments');
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return FALSE;
    }

    public function getTotalReceivedStripeAmount($start, $end, $biller_id = NULL)
    {
        $this->db->select('count(id) as total, SUM(COALESCE(amount, 0)) as total_amount', FALSE)
            ->where('type', 'received')->where('paid_by', 'stripe')
            ->where('date BETWEEN ' . $start . ' and ' . $end);
			if($biller_id != NULL){
				$this->db->where('biller_id', $biller_id);
			}
        $q = $this->db->get('payments');
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return FALSE;
    }

    public function getTotalReturnedAmount($start, $end, $biller_id = NULL)
    {
        $this->db->select('count(id) as total, SUM(COALESCE(amount, 0)) as total_amount', FALSE)
            ->where('type', 'returned')
            ->where('date BETWEEN ' . $start . ' and ' . $end);
			if($biller_id != NULL){
				$this->db->where('biller_id', $biller_id);
			}
        $q = $this->db->get('payments');
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return FALSE;
    }

    public function getWarehouseTotals($warehouse_id = NULL)
    {
        $this->db->select('sum(quantity) as total_quantity, count(id) as total_items', FALSE);
        $this->db->where('quantity !=', 0);
        if ($warehouse_id) {
            $this->db->where('warehouse_id', $warehouse_id);
        }
        $q = $this->db->get('warehouses_products');
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return FALSE;
    }
    
    public function getDailySaleRevenues($date)
    {
        $myQuery = "SELECT 
						SUM(COALESCE(erp_sales.total_items, 0)) AS total_items,
                        SUM(COALESCE(erp_sales.total, 0)) AS total, 
                        SUM(COALESCE(erp_sales.total_discount, 0)) AS discount
			FROM " . $this->db->dbprefix('sales') . "
			WHERE erp_sales.DATE LIKE  '%$date%'
			GROUP BY DATE_FORMAT( date,  '%e' )";
			
        $q = $this->db->query($myQuery, false);
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return false;
    }

    public function getDailySaleRevenuesByPM($date, $user_id)
    {
        $myQuery = "SELECT 
                        SUM(COALESCE(erp_sales.total_items, 0)) AS total_items,
                        SUM(COALESCE(erp_sales.total, 0)) AS total, 
                        SUM(COALESCE(erp_sales.total_discount, 0)) AS discount
            FROM " . $this->db->dbprefix('sales') . "
            LEFT JOIN erp_users ON erp_sales.assign_to_id = erp_users.id
            WHERE erp_sales.DATE LIKE  '%$date%'
            AND erp_users.id = $user_id
            GROUP BY DATE_FORMAT( date,  '%e' )";
            
        $q = $this->db->query($myQuery, false);
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return false;
    }

    public function getCosting($date)
    {
        $this->db->select('SUM( COALESCE( total_cost, 0 ) ) AS cost,SUM( COALESCE( total_items, 0 ) ) AS total_items, SUM( COALESCE( grand_total, 0 ) ) AS sales, SUM( total_tax + shipping + total_cost ) AS net_cost, SUM( total_tax + shipping + grand_total ) AS net_sales', FALSE)
			->where("date >=", $date.' 00:00:00')
			->where("date <=", $date.' 23:55:00')
			->where('pos !=', 1);

        $q = $this->db->get('sales');
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return false;
    }

    public function getCostingByPM($date, $user_id)
    {
        $this->db
            ->select('SUM( COALESCE( total_cost, 0 ) ) AS cost,SUM( COALESCE( total_items, 0 ) ) AS total_items, SUM( COALESCE( grand_total, 0 ) ) AS sales, SUM( total_tax + shipping + total_cost ) AS net_cost, SUM( total_tax + shipping + grand_total ) AS net_sales', FALSE)
            ->join('users', 'sales.assign_to_id = users.id', 'left')
            ->where("date >=", $date.' 00:00:00')
            ->where("date <=", $date.' 23:55:00')
            ->where('pos !=', 1)
            ->where('users.id', $user_id);

        $q = $this->db->get('sales');
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return false;
    }
	
	public function getSaleDaily($date)
    {
		$this->db->select("
		date, 
		reference_no,
		customer, 
		total_discount,
		grand_total, 
		paid,			
		(grand_total-paid) as balance, 
		payment_status")
			->where("date >=", $date.' 00:00:00')
			->where("date <=", $date.' 23:55:00');
        $q = $this->db->get('sales');
        if ($q->num_rows() > 0) {
            return $q->result();
        }
        return false;
	}

    public function getSaleDailyByPM($date, $user_id)
    {
        $this->db
            ->select("
                date, 
                reference_no,
                customer, 
                total_discount,
                grand_total, 
                paid,           
                (grand_total-paid) as balance, 
                payment_status")
            ->join('users', 'sales.assign_to_id = users.id', 'left')
            ->where("date >=", $date.' 00:00:00')
            ->where("date <=", $date.' 23:55:00')
            ->where('users.id', $user_id);
        $q = $this->db->get('sales');
        if ($q->num_rows() > 0) {
            return $q->result();
        }
        return false;
    }
	
	public function getSaleMonthly($date, $warehouse_id = NULL, $year = NULL, $month = NULL)
    {
		
		$this->db->select("
						date, 
						reference_no,
						customer, 
						total_discount,
						grand_total, 
						paid,			
						(grand_total-paid) as balance, 
						payment_status");

		if($date) {
            $this->db->where('purchases.date', $date);
        }elseif ($month) {
            $this->load->helper('date');
            $last_day = days_in_month($month, $year);
            $this->db->where('sales.date >=', $year.'-'.$month.'-01 00:00:00');
            $this->db->where('sales.date <=', $year.'-'.$month.'-'.$last_day.' 23:59:59');
        }
		 $q = $this->db->get('sales');
		if ($q->num_rows() > 0) {
            return $q->result();
        }
        return false;
		
	}

    public function getSaleMonthlyByPM($user_id, $date, $warehouse_id = NULL, $year = NULL, $month = NULL)
    {
        $this->db->select("
                        date, 
                        reference_no,
                        customer, 
                        total_discount,
                        grand_total, 
                        paid,           
                        (grand_total-paid) as balance, 
                        payment_status");

        if($date) {
            $this->db->where('purchases.date', $date);
        }elseif ($month) {
            $this->load->helper('date');
            $last_day = days_in_month($month, $year);
            $this->db->where('sales.date >=', $year.'-'.$month.'-01 00:00:00');
            $this->db->where('sales.date <=', $year.'-'.$month.'-'.$last_day.' 23:59:59');
        }
         $q = $this->db->get('sales');
        if ($q->num_rows() > 0) {
            return $q->result();
        }
        return false;
        
    }
	
	public function getPurchaseing($date)
    {
        $this->db->select("date, reference_no, supplier, status, total_discount, grand_total, paid, (grand_total-paid) as balance, payment_status")
			->where("date >=", $date.' 00:00:00')
			->where("date <=", $date.' 23:55:00');

        $q = $this->db->get('purchases');
        if ($q->num_rows() > 0) {
            return $q->result();
        }
        return false;
    }
	
	public function getMonthCosting($date, $warehouse_id = NULL, $year = NULL, $month = NULL)
    {
        $this->db->select('SUM( COALESCE( total_cost, 0 ) ) AS cost, SUM( COALESCE( grand_total, 0 ) ) AS sales, SUM( total_tax + shipping + total_cost ) AS net_cost, SUM( total_tax + shipping + grand_total ) AS net_sales', FALSE);
		
		if($date) {
            $this->db->where('sales.date', $date);
        }elseif ($month) {
            $this->load->helper('date');
            $last_day = days_in_month($month, $year);
            $this->db->where('sales.date >=', $year.'-'.$month.'-01 00:00:00');
            $this->db->where('sales.date <=', $year.'-'.$month.'-'.$last_day.' 23:59:59');
        }

        if ($warehouse_id) {
            //$this->db->join('sales', 'sales.id=costing.sale_id')
            $this->db->where('sales.warehouse_id', $warehouse_id);
        }

        $q = $this->db->get('sales');
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return false;
    }

    public function getMonthCostingByPM($user_id, $date, $warehouse_id = NULL, $year = NULL, $month = NULL)
    {
        $this->db->select('SUM( COALESCE( total_cost, 0 ) ) AS cost, SUM( COALESCE( grand_total, 0 ) ) AS sales, SUM( total_tax + shipping + total_cost ) AS net_cost, SUM( total_tax + shipping + grand_total ) AS net_sales', FALSE);
        
        if($date) {
            $this->db->where('sales.date', $date);
        }elseif ($month) {
            $this->load->helper('date');
            $last_day = days_in_month($month, $year);
            $this->db->where('sales.date >=', $year.'-'.$month.'-01 00:00:00');
            $this->db->where('sales.date <=', $year.'-'.$month.'-'.$last_day.' 23:59:59');
        }

        if ($warehouse_id) {
            //$this->db->join('sales', 'sales.id=costing.sale_id')
            $this->db->where('sales.warehouse_id', $warehouse_id);
        }

        $q = $this->db->get('sales');
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return false;
    }
	
	public function getMonthPurchaseing($date, $warehouse_id = NULL, $year = NULL, $month = NULL)
    {
        $this->db->select("date, reference_no, supplier, total_discount, status, grand_total, paid, (grand_total-paid) as balance, payment_status");
		
		if($date) {
            $this->db->where('purchases.date', $date);
        }elseif ($month) {
            $this->load->helper('date');
            $last_day = days_in_month($month, $year);
            $this->db->where('purchases.date >=', $year.'-'.$month.'-01 00:00:00');
            $this->db->where('purchases.date <=', $year.'-'.$month.'-'.$last_day.' 23:59:59');
        }
		
        $q = $this->db->get('purchases');
        if ($q->num_rows() > 0) {
            return $q->result();
        }
        return false;
    }
	
	public function getOrderDiscount($date, $warehouse_id = NULL, $year = NULL, $month = NULL)
    {
        $sdate = $date.' 00:00:00';
        $edate = $date.' 23:59:59';
        $this->db->select('SUM( COALESCE( order_discount, 0 ) ) AS order_discount', FALSE);
        if ($date) {
            $this->db->where('date >=', $sdate)->where('date <=', $edate);
        } elseif ($month) {
            $this->load->helper('date');
            $last_day = days_in_month($month, $year);
            $this->db->where('date >=', $year.'-'.$month.'-01 00:00:00');
            $this->db->where('date <=', $year.'-'.$month.'-'.$last_day.' 23:59:59');
        }

        if ($warehouse_id) {
            $this->db->where('warehouse_id', $warehouse_id);
        }

        $q = $this->db->get('sales');
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return false;
    }

    public function getOrderDiscountByPM($user_id, $date, $warehouse_id = NULL, $year = NULL, $month = NULL)
    {
        // $this->erp->print_arrays($year);
        $sdate = $date.' 00:00:00';
        $edate = $date.' 23:59:59';
        $this->db->select('SUM( COALESCE( order_discount, 0 ) ) AS order_discount', FALSE);
        if ($date) {
            $this->db->where('date >=', $sdate)->where('date <=', $edate);
        } elseif ($month) {
            $this->load->helper('date');
            $last_day = days_in_month($month, $year);
            $this->db->where('date >=', $year.'-'.$month.'-01 00:00:00');
            $this->db->where('date <=', $year.'-'.$month.'-'.$last_day.' 23:59:59');
        }

        if ($warehouse_id) {
            $this->db->where('warehouse_id', $warehouse_id);
        }

        $q = $this->db->get('sales');
        if ($q->num_rows() > 0) {
            return $q->row();
        }

        return false;
    }

    public function getExpenses($date)
    {
        $sdate = $date.' 00:00:00';
        $edate = $date.' 23:59:59';
        $this->db
            ->select('SUM( COALESCE( amount, 0 ) ) AS total,count( COALESCE( id, 0 ) ) AS count_ex', FALSE)
            ->where('date >=', $sdate)->where('date <=', $edate);

        $q = $this->db->get('expenses');
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return false;
    }

    public function getExpensesByPM($date, $user_id)
    {
        $sdate = $date.' 00:00:00';
        $edate = $date.' 23:59:59';
        $this->db
            ->select('SUM( COALESCE( amount, 0 ) ) AS total,count( COALESCE( erp_expenses.id, 0 ) ) AS count_ex', FALSE)
            ->join('users', 'expenses.created_by = users.id', 'left')
            ->where('date >=', $sdate)->where('date <=', $edate)
            ->where('users.id', $user_id);

        $q = $this->db->get('expenses');
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return false;
    }
	
	public function getExpense($date, $warehouse_id = NULL, $year = NULL, $month = NULL)
    {
        $sdate = $date.' 00:00:00';
        $edate = $date.' 23:59:59';
        $this->db->select('SUM( COALESCE( amount, 0 ) ) AS total', FALSE);
        if ($date) {
            $this->db->where('date >=', $sdate)->where('date <=', $edate);
        } elseif ($month) {
            $this->load->helper('date');
            $last_day = days_in_month($month, $year);
            $this->db->where('date >=', $year.'-'.$month.'-01 00:00:00');
            $this->db->where('date <=', $year.'-'.$month.'-'.$last_day.' 23:59:59');
        }
        

        if ($warehouse_id) {
            $this->db->where('warehouse_id', $warehouse_id);
        }

        $q = $this->db->get('expenses');
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return false;
    }
	
	public function getReturns($date, $warehouse_id = NULL, $year = NULL, $month = NULL)
    {
        $sdate = $date.' 00:00:00';
        $edate = $date.' 23:59:59';
        $this->db->select('SUM( COALESCE( grand_total, 0 ) ) AS total', FALSE)
        ->where('sale_status', 'returned');
        if ($date) {
            $this->db->where('date >=', $sdate)->where('date <=', $edate);
        } elseif ($month) {
            $this->load->helper('date');
            $last_day = days_in_month($month, $year);
            $this->db->where('date >=', $year.'-'.$month.'-01 00:00:00');
            $this->db->where('date <=', $year.'-'.$month.'-'.$last_day.' 23:59:59');
        }

        if ($warehouse_id) {
            $this->db->where('warehouse_id', $warehouse_id);
        }

        $q = $this->db->get('sales');
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return false;
    }
    
	public function getSaleDetail($product_code)
    {
        $this->db->order_by('sale_items.id', 'asc');
		$this->db->join('sales', 'sales.id = sale_items.sale_id', 'left');
        $q = $this->db->get_where('sale_items', array('product_code' => $product_code));
        if ($q->num_rows() > 0) {
            foreach (($q->result()) as $row) {
                $data[] = $row;
            }
            return $data;
        }
    }
	
	public function getPurchaseDetail($product_code)
    {
		$this->db->select('*');
		$this->db->from('purchase_items');
		$this->db->join('purchases', 'purchase_items.purchase_id = purchases.id');
		$this->db->where('purchase_items.product_code', $product_code);
		$this->db->where('purchase_items.status <>', 'ordered');
        //$this->db->order_by('id', 'asc');
		$q = $this->db->get();
        //$q = $this->db->get_where('purchase_items', array('product_code' => $product_code));
        if ($q->num_rows() > 0) {
            foreach (($q->result()) as $row) {
                $data[] = $row;
            }
            return $data;
        }
    }
	
	public function getPurchaseDetailSupplier($product_code, $supplier_id)
    {	
		$this->db->select('*');
		$this->db->from('purchase_items');
		$this->db->join('purchases', 'purchase_items.purchase_id = purchases.id');
		$this->db->where('purchase_items.product_code', $product_code);
		$this->db->where('purchases.supplier_id', $supplier_id);
		$this->db->where('purchase_items.status <>', 'ordered');
        //$this->db->order_by('id', 'asc');
		$q = $this->db->get();
        //$q = $this->db->get_where('purchase_items', array('product_code' => $product_code));
        if ($q->num_rows() > 0) {
            foreach (($q->result()) as $row) {
                $data[] = $row;
            }
            return $data;
        }
    }
	public function Count_Sale_discount($date){
		
		$myQuery = "SELECT count( ( COALESCE( id, 0 ) ) ) AS count_id
				FROM erp_sales 
				WHERE DATE_FORMAT( date,  '%Y-%m-%d' ) =  '{$date}' and order_discount!=''";
			
        $q = $this->db->query($myQuery, false);
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return false;
	}

    public function countSaleDiscountByPM($date, $user_id){
        
        $myQuery = "SELECT count( ( COALESCE( erp_sales.id, 0 ) ) ) AS count_id
                FROM erp_sales
                LEFT JOIN erp_users ON erp_sales.assign_to_id = erp_users.id
                WHERE DATE_FORMAT( date,  '%Y-%m-%d' ) =  '{$date}' and order_discount!=''
                AND erp_users.id = $user_id";
            
        $q = $this->db->query($myQuery, false);
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return false;
    }
	

	public function getSalesReturnDate($date)
    {
		$this->db->select("SUM( COALESCE( ABS({$this->db->dbprefix('return_sales')}.grand_total), 0 ) ) AS paid, SUM( ( COALESCE( quantity, 0 ) ) ) AS quantity, SUM(( COALESCE( {$this->db->dbprefix('sales')}.order_discount, 0 ) ) ) AS order_discount", FALSE)
			->join('return_sales', 'sales.return_id=return_sales.id', 'left')
			->join('return_items', 'return_items.return_id=return_sales.id', 'left')
			//->like('quantity', '-')
			->where("DATE({$this->db->dbprefix('sales')}.date)", $date);

        $q = $this->db->get('sales');
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return false;
    }

    public function getSalesReturnDateByPM($date, $user_id)
    {
        $this->db
            ->select("SUM( COALESCE( ABS({$this->db->dbprefix('return_sales')}.grand_total), 0 ) ) AS paid, SUM( ( COALESCE( quantity, 0 ) ) ) AS quantity, SUM(( COALESCE( {$this->db->dbprefix('sales')}.order_discount, 0 ) ) ) AS order_discount", FALSE)
            ->join('return_sales', 'sales.return_id=return_sales.id', 'left')
            ->join('return_items', 'return_items.return_id=return_sales.id', 'left')
            ->join('users', 'sales.assign_to_id = users.id', 'left')
            ->where("DATE({$this->db->dbprefix('sales')}.date)", $date)
            ->where('users.id', $user_id);

        $q = $this->db->get('sales');
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return false;
    }

	public function getTotalDiscountDate($date)
    {
		 $this->db->select('SUM( COALESCE( total_discount, 0 ) ) AS discount', FALSE)
        ->where('DATE(date)', $date);

        $q = $this->db->get('sales');
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return false;
    }

    public function getTotalDiscountDateByPM($date, $user_id)
    {
         $this->db
             ->select('SUM( COALESCE( total_discount, 0 ) ) AS discount', FALSE)
             ->join('users', 'sales.assign_to_id = users.id', 'left')
             ->where('DATE(date)', $date)
             ->where('users.id', $user_id);

        $q = $this->db->get('sales');
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return false;
    }

	public function getTotalCosts($start, $end, $biller_id = NULL)
    {
        $this->db->select('SUM( COALESCE( purchase_unit_cost, 0 ) * quantity ) AS cost', FALSE)
        ->where('date BETWEEN ' . $start . ' and ' . $end);
        $q = $this->db->get('costing');
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return false;
    }
	public function getDailyPurchases($year, $month, $warehouse_id = NULL)
    {
        $myQuery = "SELECT DATE_FORMAT( date,  '%e' ) AS date, 
		SUM( COALESCE( product_tax, 0 ) ) AS tax1, 
		SUM( COALESCE( order_tax, 0 ) ) AS tax2, 
		SUM( COALESCE( total, 0 ) ) AS total, 
		SUM( COALESCE( order_discount, 0 ) ) AS discount, 
		SUM( COALESCE( shipping, 0 ) ) AS shipping
            FROM " . $this->db->dbprefix('purchases') . " WHERE ";
        if ($warehouse_id) {
            $myQuery .= " warehouse_id = {$warehouse_id} AND ";
        }
        $myQuery .= " DATE_FORMAT( date,  '%Y-%m' ) =  '{$year}-{$month}'
            GROUP BY DATE_FORMAT( date,  '%e' )";
        $q = $this->db->query($myQuery, false);
        if ($q->num_rows() > 0) {
            foreach (($q->result()) as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return FALSE;
    }
/*
    public function getmonthlyPurchases()
    {
        $myQuery = "SELECT (CASE WHEN date_format( date, '%b' ) Is Null THEN 0 ELSE date_format( date, '%b' ) END) as month, SUM( COALESCE( total, 0 ) ) AS purchases FROM purchases WHERE date >= date_sub( now( ) , INTERVAL 12 MONTH ) GROUP BY date_format( date, '%b' ) ORDER BY date_format( date, '%m' ) ASC";
        $q = $this->db->query($myQuery);
        if ($q->num_rows() > 0) {
            foreach (($q->result()) as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return FALSE;
    }
*/
    public function getMonthlyPurchases($year, $warehouse_id = NULL)
    {
        $myQuery = "SELECT DATE_FORMAT( date,  '%c' ) AS date, 
		SUM( COALESCE( product_tax, 0 ) ) AS tax1, 
		SUM( COALESCE( order_tax, 0 ) ) AS tax2, 
		SUM( COALESCE( total, 0 ) ) AS total, 
		SUM( COALESCE( order_discount, 0 ) ) AS discount, 
		SUM( COALESCE( shipping, 0 ) ) AS shipping
            FROM " . $this->db->dbprefix('purchases') . " WHERE ";
        if ($warehouse_id) {
            $myQuery .= " warehouse_id = {$warehouse_id} AND ";
        }
        $myQuery .= " DATE_FORMAT( date,  '%Y' ) =  '{$year}'
            GROUP BY date_format( date, '%c' ) ORDER BY date_format( date, '%c' ) ASC";
        $q = $this->db->query($myQuery, false);
        if ($q->num_rows() > 0) {
            foreach (($q->result()) as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return FALSE;
    }

    public function getStaffDailyPurchases($user_id, $year, $month, $warehouse_id = NULL)
    {
        $myQuery = "SELECT DATE_FORMAT( date,  '%e' ) AS date, 
		SUM( COALESCE( product_tax, 0 ) ) AS tax1, 
		SUM( COALESCE( order_tax, 0 ) ) AS tax2, 
		SUM( COALESCE( total, 0 ) ) AS total, 
		SUM( COALESCE( order_discount, 0 ) ) AS discount, 
		SUM( COALESCE( shipping, 0 ) ) AS shipping
            FROM " . $this->db->dbprefix('purchases')." WHERE ";
        if ($warehouse_id) {
            $myQuery .= " warehouse_id = {$warehouse_id} AND ";
        }
        $myQuery .= " created_by = {$user_id} AND DATE_FORMAT( date,  '%Y-%m' ) =  '{$year}-{$month}'
            GROUP BY DATE_FORMAT( date,  '%e' )";
        $q = $this->db->query($myQuery, false);
        if ($q->num_rows() > 0) {
            foreach (($q->result()) as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return FALSE;
    }

    public function getStaffMonthlyPurchases($user_id, $year, $warehouse_id = NULL)
    {
        $myQuery = "SELECT DATE_FORMAT( date,  '%c' ) AS date, 
		SUM( COALESCE( product_tax, 0 ) ) AS tax1, 
		SUM( COALESCE( order_tax, 0 ) ) AS tax2, 
		SUM( COALESCE( total, 0 ) ) AS total, 
		SUM( COALESCE( order_discount, 0 ) ) AS discount, 
		SUM( COALESCE( shipping, 0 ) ) AS shipping
            FROM " . $this->db->dbprefix('purchases') . " WHERE ";
        if ($warehouse_id) {
            $myQuery .= " warehouse_id = {$warehouse_id} AND ";
        }
        $myQuery .= " created_by = {$user_id} AND DATE_FORMAT( date,  '%Y' ) =  '{$year}'
            GROUP BY date_format( date, '%c' ) ORDER BY date_format( date, '%c' ) ASC";
        $q = $this->db->query($myQuery, false);
        if ($q->num_rows() > 0) {
            foreach (($q->result()) as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return FALSE;
    }
	
	public function getReportW($product = NULL, $category = NULL, $supplier = NULL, $start_date = NULL, $end_date = NULL){
		$where_purchase = "where 1=1 AND {$this->db->dbprefix('purchase_items')}.status <> 'ordered' AND {$this->db->dbprefix('purchase_items')}.purchase_id != ''";
		$where_sale='where 1=1';
		if ($start_date) {
            $start_date = $this->erp->fld($start_date);
            $end_date = $end_date ? $this->erp->fld($end_date) : date('Y-m-d');

            $pp = "( SELECT pi.product_id, 
						SUM( pi.quantity * (CASE WHEN pi.option_id <> 0 THEN pi.vqty_unit ELSE 1 END) ) purchasedQty, 
						SUM( tpi.quantity_balance ) balacneQty, 
						SUM((CASE WHEN pi.option_id <> 0 THEN pi.vcost ELSE pi.unit_cost END) *  tpi.quantity_balance ) balacneValue, 
						SUM( pi.unit_cost * pi.quantity ) totalPurchase, 
                        SUM(pi.unit_cost) AS totalCost,
						SUM(pi.quantity) AS Pquantity,
						pi.date as pdate 
						FROM ( SELECT {$this->db->dbprefix('purchase_items')}.date as date, 
									{$this->db->dbprefix('purchase_items')}.product_id, 
									purchase_id, 
									SUM({$this->db->dbprefix('purchase_items')}.quantity) as quantity, 
									unit_cost,
									option_id,
									ppv.qty_unit AS vqty_unit,
									ppv.cost AS vcost,
									ppv.quantity AS vquantity 
									FROM erp_purchase_items 
									JOIN {$this->db->dbprefix('products')} p 
									ON p.id = {$this->db->dbprefix('purchase_items')}.product_id 
									LEFT JOIN " . $this->db->dbprefix('product_variants') . " ppv 
									ON ppv.id={$this->db->dbprefix('purchase_items')}.option_id  
									WHERE {$this->db->dbprefix('purchase_items')}.date >= '{$start_date}' AND {$this->db->dbprefix('purchase_items')}.date < '{$end_date}' 
									GROUP BY {$this->db->dbprefix('purchase_items')}.product_id ) pi 
						LEFT JOIN ( SELECT product_id, 
										SUM(quantity_balance) as quantity_balance 
										FROM {$this->db->dbprefix('purchase_items')} 
										GROUP BY product_id ) tpi on tpi.product_id = pi.product_id 
						GROUP BY pi.product_id ) PCosts";

			$sp = "( SELECT si.product_id, 
						SUM( si.quantity*(CASE WHEN si.option_id <> 0 THEN spv.qty_unit ELSE 1 END)) soldQty, 
						SUM( si.subtotal ) totalSale, 
						SUM( si.quantity) AS Squantity,
						s.date as sdate
						FROM " . $this->db->dbprefix('sales') . " s 
						JOIN " . $this->db->dbprefix('sale_items') . " si 
						ON s.id = si.sale_id 
						LEFT JOIN " . $this->db->dbprefix('product_variants') . " spv 
						ON spv.id=si.option_id
						WHERE s.date >= '{$start_date}' AND s.date < '{$end_date}' 
						GROUP BY si.product_id ) PSales";

			$ppb = "( SELECT pi.product_id, 
						SUM( pi.quantity ) purchasedQty, 
						SUM( tpi.quantity_balance ) balacneQty, 
						SUM( (CASE WHEN pi.option_id <> 0 THEN pi.vcost ELSE pi.unit_cost END) *  tpi.quantity_balance ) balacneValue, 
						SUM( pi.unit_cost * pi.quantity ) totalPurchase, 
						pi.date as pdate 
						FROM ( SELECT {$this->db->dbprefix('purchase_items')}.date as date, 
									{$this->db->dbprefix('purchase_items')}.product_id, 
									purchase_id, 
									SUM({$this->db->dbprefix('purchase_items')}.quantity) as quantity, 
									unit_cost,
									option_id,
									ppv.qty_unit AS vqty_unit,
									ppv.cost AS vcost,
									ppv.quantity AS vquantity 
									FROM erp_purchase_items 
									JOIN {$this->db->dbprefix('products')} p 
									ON p.id = {$this->db->dbprefix('purchase_items')}.product_id 
									LEFT JOIN " . $this->db->dbprefix('product_variants') . " ppv 
									ON ppv.id={$this->db->dbprefix('purchase_items')}.option_id  
									WHERE {$this->db->dbprefix('purchase_items')}.date < '{$start_date}'
									GROUP BY {$this->db->dbprefix('purchase_items')}.product_id ) pi 
						LEFT JOIN ( SELECT product_id, 
										SUM(quantity_balance) as quantity_balance 
										FROM {$this->db->dbprefix('purchase_items')} 
										GROUP BY product_id ) tpi on tpi.product_id = pi.product_id GROUP BY pi.product_id ) PCostsBegin";
            
			$spb = "( SELECT si.product_id, 
						SUM( si.quantity*(CASE WHEN si.option_id <> 0 THEN spv.qty_unit ELSE 1 END)) saleQty, 
						SUM( si.subtotal ) totalSale, 
						SUM( si.quantity) AS Squantity,
						s.date as sdate
						FROM " . $this->db->dbprefix('sales') . " s 
						JOIN " . $this->db->dbprefix('sale_items') . " si 
						ON s.id = si.sale_id 
						LEFT JOIN " . $this->db->dbprefix('product_variants') . " spv 
						ON spv.id=si.option_id
						WHERE s.date < '{$start_date}'
						GROUP BY si.product_id ) PSalesBegin";
        } 
		else {
			$current_date = date('Y-m-d');
			$prevouse_date = date('Y').'-'.date('m').'-'.'01';
			$pp = "( SELECT pi.product_id, 
						SUM( pi.quantity * (CASE WHEN pi.option_id <> 0 THEN pi.vqty_unit ELSE 1 END) ) purchasedQty, 
						SUM( tpi.quantity_balance ) balacneQty, 
						SUM( (CASE WHEN pi.option_id <> 0 THEN pi.vcost ELSE pi.unit_cost END) *  tpi.quantity_balance ) balacneValue, 
						SUM( pi.unit_cost * pi.quantity ) totalPurchase, 
                        SUM(pi.unit_cost) AS totalCost,
						SUM(pi.quantity) AS Pquantity,
						pi.date as pdate 
						FROM ( SELECT {$this->db->dbprefix('purchase_items')}.date as date, 
									{$this->db->dbprefix('purchase_items')}.product_id, 
									purchase_id, 
									SUM({$this->db->dbprefix('purchase_items')}.quantity) as quantity, 
									unit_cost ,
									option_id,
									ppv.qty_unit AS vqty_unit,
									ppv.cost AS vcost,
									ppv.quantity AS vquantity
									FROM {$this->db->dbprefix('purchase_items')} 
									JOIN {$this->db->dbprefix('products')} p 
									ON p.id = {$this->db->dbprefix('purchase_items')}.product_id 
									LEFT JOIN " . $this->db->dbprefix('product_variants') . " ppv 
									ON ppv.id={$this->db->dbprefix('purchase_items')}.option_id  
									".$where_purchase." 
									GROUP BY {$this->db->dbprefix('purchase_items')}.product_id ) pi 			
						LEFT JOIN ( SELECT product_id, 
										SUM(quantity_balance) as quantity_balance 
										FROM {$this->db->dbprefix('purchase_items')} GROUP BY product_id 
									) tpi on tpi.product_id = pi.product_id GROUP BY pi.product_id ) PCosts";

			$sp = "( SELECT si.product_id, 
						COALESCE(SUM( si.quantity*(CASE WHEN si.option_id <> 0 THEN spv.qty_unit ELSE 1 END)),0) soldQty, 
						SUM( si.subtotal ) totalSale, 
						SUM( si.quantity) AS Squantity,
						s.date as sdate
						FROM " . $this->db->dbprefix('sales') . " s 
						JOIN " . $this->db->dbprefix('sale_items') . " si 
						ON s.id = si.sale_id 
						LEFT JOIN " . $this->db->dbprefix('product_variants') . " spv 
						ON spv.id=si.option_id
						".$where_sale."
						GROUP BY si.product_id ) PSales";

			
			$ppb = "( SELECT pi.product_id, 
						SUM(pi.quantity) AS purchasedQty, 
						SUM( tpi.quantity_balance ) balacneQty, 
						SUM( (CASE WHEN pi.option_id <> 0 THEN pi.vcost ELSE pi.unit_cost END) * tpi.quantity_balance ) balacneValue, 
						SUM(pi.unit_cost * pi.quantity) totalPurchase, 
						pi.date as pdate 
						FROM ( SELECT {$this->db->dbprefix('purchase_items')}.date as date, 
									{$this->db->dbprefix('purchase_items')}.product_id, 
									purchase_id, 
									SUM({$this->db->dbprefix('purchase_items')}.quantity) as quantity, 
									unit_cost ,
									option_id,
									ppv.qty_unit AS vqty_unit,
									ppv.cost AS vcost,
									ppv.quantity AS vquantity
									FROM {$this->db->dbprefix('purchase_items')} 
									JOIN {$this->db->dbprefix('products')} p 
									ON p.id = {$this->db->dbprefix('purchase_items')}.product_id 
									LEFT JOIN " . $this->db->dbprefix('product_variants') . " ppv 
									ON ppv.id={$this->db->dbprefix('purchase_items')}.option_id  
									".$where_purchase." 
									AND {$this->db->dbprefix('purchase_items')}.date < '{$prevouse_date}' 
									GROUP BY {$this->db->dbprefix('purchase_items')}.product_id ) pi 			
						LEFT JOIN ( SELECT product_id, 
										SUM(quantity_balance) as quantity_balance 
										FROM {$this->db->dbprefix('purchase_items')} 
										GROUP BY product_id ) tpi on tpi.product_id = pi.product_id GROUP BY pi.product_id ) PCostsBegin";
			
            $spb = "( SELECT si.product_id, 
						COALESCE(SUM( si.quantity*(CASE WHEN si.option_id <> 0 THEN spv.qty_unit ELSE 1 END)),0) saleQty, 
						SUM( si.subtotal ) totalSale, 
						SUM( si.quantity) AS Squantity,
						s.date as sdate
						FROM " . $this->db->dbprefix('sales') . " s 
						JOIN " . $this->db->dbprefix('sale_items') . " si 
						ON s.id = si.sale_id 
						LEFT JOIN " . $this->db->dbprefix('product_variants') . " spv 
						ON spv.id=si.option_id
						".$where_sale."
						AND s.date < '{$prevouse_date}'
						GROUP BY si.product_id ) PSalesBegin";
			
        }
						
		$this->db->select($this->db->dbprefix('products') . ".id as product_id, 
				" . $this->db->dbprefix('products') . ".code as product_code, 
				" . $this->db->dbprefix('products') . ".name,
				COALESCE( PCostsBegin.purchasedQty-PSalesBegin.saleQty, 0 ) as BeginPS,
				CONCAT(COALESCE (PCosts.Pquantity, 0)) AS purchased,
				COALESCE( PSales.Squantity, 0 ) + COALESCE (
                        (
                            SELECT
                                SUM(si.quantity * ci.quantity)
                            FROM
                                ".$this->db->dbprefix('combo_items') . " ci
                            INNER JOIN erp_sale_items si ON si.product_id = ci.product_id
                            WHERE
                                ci.item_code = ".$this->db->dbprefix('products') . ".code
                        ),
                        0
                    ) as sold,
				COALESCE (COALESCE (
						PCostsBegin.purchasedQty-PSalesBegin.saleQty,
						0
					)+COALESCE (PCosts.Pquantity, 0) - COALESCE( PSales.Squantity , 0 ) -  COALESCE (
                        (
                            SELECT
                                SUM(si.quantity * ci.quantity)
                            FROM
								".$this->db->dbprefix('combo_items') . " ci
                            INNER JOIN erp_sale_items si ON si.product_id = ci.product_id
                            WHERE
                                ci.item_code = ".$this->db->dbprefix('products') . ".code
                        ),
                        0
                    ) ) AS balance", 
				FALSE)
				 ->from('products')
				 ->join($sp, 'products.id = PSales.product_id', 'left')
				 ->join($pp, 'products.id = PCosts.product_id', 'left')
				 ->join($spb, 'products.id = PSalesBegin.product_id', 'left')
                 ->join($ppb, 'products.id = PCostsBegin.product_id', 'left')
				 ->join('warehouses_products wp', 'products.id=wp.product_id', 'left')
				 ->join('categories', 'products.category_id=categories.id', 'left')
				 ->group_by("products.id");
		if($product){
			$this->db->where($this->db->dbprefix('products') . ".id", $product);
		}
		if ($category) {
			$this->db->where($this->db->dbprefix('products') . ".category_id", $category);
		}
		
		if($start_date && $end_date)
		{
			$this->db->where("( date(PCostsBegin.pdate) BETWEEN '{$start_date}' AND  '{$end_date}' 
			OR date(PSalesBegin.sdate) BETWEEN '{$start_date}' AND  '{$end_date}'
			OR date(PCosts.pdate) BETWEEN '{$start_date}' AND  '{$end_date}'
			OR date(PSales.sdate) BETWEEN '{$start_date}' AND  '{$end_date}' )");
		}
			
		if ($supplier) {
			$this->db->where("products.supplier1 = '".$supplier."' or products.supplier2 = '".$supplier."' or products.supplier3 = '".$supplier."' or products.supplier4 = '".$supplier."' or products.supplier5 = '".$supplier."'");
		}
		$q = $this->db->get();
        if ($q->num_rows() > 0) {
            return $q->result();
        }
        return false;		
	}
	
	public function getInOutByID($id){
		if ($this->input->get('product')) {
            $product = $this->input->get('product');
        } else {
            $product = NULL;
        }
        if ($this->input->get('category')) {
            $category = $this->input->get('category');
        } else {
            $category = NULL;
        }
        if ($this->input->get('in_out')) {
            $in_out = $this->input->get('in_out');
        } else {
            $in_out = NULL;
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
		if ($this->input->get('supplier')) {
            $supplier = $this->input->get('supplier');
        } else {
            $supplier = NULL;
        }
		if ($this->input->get('warehouse')) {
            $warehouse = $this->input->get('warehouse');
			$where_sale='where si.warehouse_id='.$warehouse;
			$where_purchase="where {$this->db->dbprefix('purchase_items')}.warehouse_id=".$warehouse . "AND {$this->db->dbprefix('purchase_items')}.status <> 'ordered'";
        } else {
            $warehouse = NULL;
			$where_purchase = "where 1=1 AND {$this->db->dbprefix('purchase_items')}.status <> 'ordered' AND {$this->db->dbprefix('purchase_items')}.purchase_id != ''";
			//$where_purchase = "where 1=1 AND {$this->db->dbprefix('purchase_items')}.status <> 'ordered'";
			$where_sale='where 1=1';
        }
        if ($start_date) {
            $start_date = $this->erp->fld($start_date);
            $end_date = $end_date ? $this->erp->fld($end_date) : date('Y-m-d');

            $pp = "( SELECT pi.product_id, 
						SUM( pi.quantity * (CASE WHEN pi.option_id <> 0 THEN pi.vqty_unit ELSE 1 END) ) purchasedQty, 
						SUM( tpi.quantity_balance ) balacneQty, 
						SUM((CASE WHEN pi.option_id <> 0 THEN pi.vcost ELSE pi.unit_cost END) *  tpi.quantity_balance ) balacneValue, 
						SUM( pi.unit_cost * pi.quantity ) totalPurchase, 
                        SUM(pi.unit_cost) AS totalCost,
						SUM(pi.quantity) AS Pquantity,
						pi.date as pdate 
						FROM ( SELECT {$this->db->dbprefix('purchase_items')}.date as date, 
									{$this->db->dbprefix('purchase_items')}.product_id, 
									purchase_id, 
									SUM({$this->db->dbprefix('purchase_items')}.quantity) as quantity, 
									unit_cost,
									option_id,
									ppv.qty_unit AS vqty_unit,
									ppv.cost AS vcost,
									ppv.quantity AS vquantity 
									FROM erp_purchase_items 
									JOIN {$this->db->dbprefix('products')} p 
									ON p.id = {$this->db->dbprefix('purchase_items')}.product_id 
									LEFT JOIN " . $this->db->dbprefix('product_variants') . " ppv 
									ON ppv.id={$this->db->dbprefix('purchase_items')}.option_id  
									WHERE {$this->db->dbprefix('purchase_items')}.date >= '{$start_date}' AND {$this->db->dbprefix('purchase_items')}.date < '{$end_date}' 
									GROUP BY {$this->db->dbprefix('purchase_items')}.product_id ) pi 
						LEFT JOIN ( SELECT product_id, 
										SUM(quantity_balance) as quantity_balance 
										FROM {$this->db->dbprefix('purchase_items')} 
										GROUP BY product_id ) tpi on tpi.product_id = pi.product_id 
						GROUP BY pi.product_id ) PCosts";

			$sp = "( SELECT si.product_id, 
						SUM( si.quantity*(CASE WHEN si.option_id <> 0 THEN spv.qty_unit ELSE 1 END)) soldQty, 
						SUM( si.subtotal ) totalSale, 
						SUM( si.quantity) AS Squantity,
						s.date as sdate
						FROM " . $this->db->dbprefix('sales') . " s 
						JOIN " . $this->db->dbprefix('sale_items') . " si 
						ON s.id = si.sale_id 
						LEFT JOIN " . $this->db->dbprefix('product_variants') . " spv 
						ON spv.id=si.option_id
						WHERE s.date >= '{$start_date}' AND s.date < '{$end_date}' 
						GROUP BY si.product_id ) PSales";

			$ppb = "( SELECT pi.product_id, 
						SUM( pi.quantity ) purchasedQty, 
						SUM( tpi.quantity_balance ) balacneQty, 
						SUM( (CASE WHEN pi.option_id <> 0 THEN pi.vcost ELSE pi.unit_cost END) *  tpi.quantity_balance ) balacneValue, 
						SUM( pi.unit_cost * pi.quantity ) totalPurchase, 
						pi.date as pdate 
						FROM ( SELECT {$this->db->dbprefix('purchase_items')}.date as date, 
									{$this->db->dbprefix('purchase_items')}.product_id, 
									purchase_id, 
									SUM({$this->db->dbprefix('purchase_items')}.quantity) as quantity, 
									unit_cost,
									option_id,
									ppv.qty_unit AS vqty_unit,
									ppv.cost AS vcost,
									ppv.quantity AS vquantity 
									FROM erp_purchase_items 
									JOIN {$this->db->dbprefix('products')} p 
									ON p.id = {$this->db->dbprefix('purchase_items')}.product_id 
									LEFT JOIN " . $this->db->dbprefix('product_variants') . " ppv 
									ON ppv.id={$this->db->dbprefix('purchase_items')}.option_id  
									WHERE {$this->db->dbprefix('purchase_items')}.date < '{$start_date}'
									GROUP BY {$this->db->dbprefix('purchase_items')}.product_id ) pi 
						LEFT JOIN ( SELECT product_id, 
										SUM(quantity_balance) as quantity_balance 
										FROM {$this->db->dbprefix('purchase_items')} 
										GROUP BY product_id ) tpi on tpi.product_id = pi.product_id GROUP BY pi.product_id ) PCostsBegin";
            
			$spb = "( SELECT si.product_id, 
						SUM( si.quantity*(CASE WHEN si.option_id <> 0 THEN spv.qty_unit ELSE 1 END)) saleQty, 
						SUM( si.subtotal ) totalSale, 
						SUM( si.quantity) AS Squantity,
						s.date as sdate
						FROM " . $this->db->dbprefix('sales') . " s 
						JOIN " . $this->db->dbprefix('sale_items') . " si 
						ON s.id = si.sale_id 
						LEFT JOIN " . $this->db->dbprefix('product_variants') . " spv 
						ON spv.id=si.option_id
						WHERE s.date < '{$start_date}'
						GROUP BY si.product_id ) PSalesBegin";
        } else {
			$current_date = date('Y-m-d');
			$prevouse_date = date('Y').'-'.date('m').'-'.'01';
            //$pp = "( SELECT pi.product_id, SUM( pi.quantity ) purchasedQty, SUM( tpi.quantity_balance ) balacneQty, SUM( pi.unit_cost * tpi.quantity_balance ) balacneValue, SUM( pi.unit_cost * pi.quantity ) totalPurchase, pi.date as pdate from ( SELECT p.date as date, product_id, purchase_id, SUM(quantity) as quantity, unit_cost from erp_purchase_items JOIN {$this->db->dbprefix('purchases')} p on p.id = {$this->db->dbprefix('purchase_items')}.purchase_id GROUP BY {$this->db->dbprefix('purchase_items')}.product_id ) pi LEFT JOIN ( SELECT product_id, SUM(quantity_balance) as quantity_balance from {$this->db->dbprefix('purchase_items')} GROUP BY product_id ) tpi on tpi.product_id = pi.product_id GROUP BY pi.product_id ) PCosts";
            //$sp = "( SELECT si.product_id, SUM( si.quantity ) soldQty, SUM( si.subtotal ) totalSale, s.date as sdate from " . $this->db->dbprefix('sales') . " s JOIN " . $this->db->dbprefix('sale_items') . " si on s.id = si.sale_id GROUP BY si.product_id ) PSales";
			$pp = "( SELECT pi.product_id, 
						SUM( pi.quantity * (CASE WHEN pi.option_id <> 0 THEN pi.vqty_unit ELSE 1 END) ) purchasedQty, 
						SUM( tpi.quantity_balance ) balacneQty, 
						SUM( (CASE WHEN pi.option_id <> 0 THEN pi.vcost ELSE pi.unit_cost END) *  tpi.quantity_balance ) balacneValue, 
						SUM( pi.unit_cost * pi.quantity ) totalPurchase, 
                        SUM(pi.unit_cost) AS totalCost,
						SUM(pi.quantity) AS Pquantity,
						pi.date as pdate 
						FROM ( SELECT {$this->db->dbprefix('purchase_items')}.date as date, 
									{$this->db->dbprefix('purchase_items')}.product_id, 
									purchase_id, 
									SUM({$this->db->dbprefix('purchase_items')}.quantity) as quantity, 
									unit_cost ,
									option_id,
									ppv.qty_unit AS vqty_unit,
									ppv.cost AS vcost,
									ppv.quantity AS vquantity
									FROM {$this->db->dbprefix('purchase_items')} 
									LEFT JOIN " . $this->db->dbprefix('purchases') . " pp 
									ON pp.id = {$this->db->dbprefix('purchase_items')}.purchase_id  
									JOIN {$this->db->dbprefix('products')} p 
									ON p.id = {$this->db->dbprefix('purchase_items')}.product_id 
									LEFT JOIN " . $this->db->dbprefix('product_variants') . " ppv 
									ON ppv.id={$this->db->dbprefix('purchase_items')}.option_id  
									".$where_purchase." 
									".$where_p_biller."
									GROUP BY {$this->db->dbprefix('purchase_items')}.product_id ) pi 			
						LEFT JOIN ( SELECT product_id, 
										SUM(quantity_balance) as quantity_balance 
										FROM {$this->db->dbprefix('purchase_items')} GROUP BY product_id 
									) tpi on tpi.product_id = pi.product_id GROUP BY pi.product_id ) PCosts";

			$sp = "( SELECT si.product_id, 
						COALESCE(SUM( si.quantity*(CASE WHEN si.option_id <> 0 THEN spv.qty_unit ELSE 1 END)),0) soldQty, 
						SUM( si.subtotal ) totalSale, 
						SUM( si.quantity) AS Squantity,
						s.date as sdate
						FROM " . $this->db->dbprefix('sales') . " s 
						JOIN " . $this->db->dbprefix('sale_items') . " si 
						ON s.id = si.sale_id 
						LEFT JOIN " . $this->db->dbprefix('product_variants') . " spv 
						ON spv.id=si.option_id
						".$where_sale."
						".$where_s_biller."
						GROUP BY si.product_id ) PSales";

			
			$ppb = "( SELECT pi.product_id, 
						SUM(pi.quantity) AS purchasedQty, 
						SUM( tpi.quantity_balance ) balacneQty, 
						SUM( (CASE WHEN pi.option_id <> 0 THEN pi.vcost ELSE pi.unit_cost END) * tpi.quantity_balance ) balacneValue, 
						SUM(pi.unit_cost * pi.quantity) totalPurchase, 
						pi.date as pdate 
						FROM ( SELECT {$this->db->dbprefix('purchase_items')}.date as date, 
									{$this->db->dbprefix('purchase_items')}.product_id, 
									purchase_id, 
									SUM({$this->db->dbprefix('purchase_items')}.quantity) as quantity, 
									unit_cost ,
									option_id,
									ppv.qty_unit AS vqty_unit,
									ppv.cost AS vcost,
									ppv.quantity AS vquantity
									FROM {$this->db->dbprefix('purchase_items')} 
									LEFT JOIN " . $this->db->dbprefix('purchases') . " pp 
									ON pp.id={$this->db->dbprefix('purchase_items')}.purchase_id  
									JOIN {$this->db->dbprefix('products')} p 
									ON p.id = {$this->db->dbprefix('purchase_items')}.product_id 
									LEFT JOIN " . $this->db->dbprefix('product_variants') . " ppv 
									ON ppv.id={$this->db->dbprefix('purchase_items')}.option_id  
									".$where_purchase." 
									".$where_p_biller."
									AND {$this->db->dbprefix('purchase_items')}.date < '{$prevouse_date}' 
									GROUP BY {$this->db->dbprefix('purchase_items')}.product_id ) pi 			
						LEFT JOIN ( SELECT product_id, 
										SUM(quantity_balance) as quantity_balance 
										FROM {$this->db->dbprefix('purchase_items')} 
										GROUP BY product_id ) tpi on tpi.product_id = pi.product_id GROUP BY pi.product_id ) PCostsBegin";
			
            $spb = "( SELECT si.product_id, 
						COALESCE(SUM( si.quantity*(CASE WHEN si.option_id <> 0 THEN spv.qty_unit ELSE 1 END)),0) saleQty, 
						SUM( si.subtotal ) totalSale, 
						SUM( si.quantity) AS Squantity,
						s.date as sdate
						FROM " . $this->db->dbprefix('sales') . " s 
						JOIN " . $this->db->dbprefix('sale_items') . " si 
						ON s.id = si.sale_id 
						LEFT JOIN " . $this->db->dbprefix('product_variants') . " spv 
						ON spv.id=si.option_id
						".$where_sale."
						".$where_s_biller."
						AND s.date < '{$prevouse_date}'
						GROUP BY si.product_id ) PSalesBegin";
        }
			$year = date('Y');
			$month = date('m');
			$YMD = $this->site->months($year, $month);
			if($YMD->date == ""){
				$LYMD = '0000-00-00';
			}else{
				$LYMD = $YMD->date;
			}
		$this->db->select($this->db->dbprefix('products') . ".id as product_id, 
				" . $this->db->dbprefix('products') . ".code as product_code, 
				" . $this->db->dbprefix('products') . ".name,
				COALESCE ((
					SELECT 
						SUM(
							" . $this->db->dbprefix('purchase_items') . ".quantity_balance
						) AS quantity
					FROM
						". $this->db->dbprefix('purchase_items') ."
					JOIN " . $this->db->dbprefix('products') . "  p ON p.id = " . $this->db->dbprefix('purchase_items') . ".product_id
					LEFT JOIN " . $this->db->dbprefix('product_variants') . " ppv ON ppv.id =" . $this->db->dbprefix('purchase_items') . ".option_id 
					WHERE DATE_FORMAT(" . $this->db->dbprefix('purchase_items') . ".date, '%Y-%m-%d') = '".$LYMD."'
					AND  (p.id) = ".$id."
					AND " . $this->db->dbprefix('purchase_items') . ".status <> 'ordered'
					GROUP BY
						DATE_FORMAT(" . $this->db->dbprefix('purchase_items') . ".date, '%Y-%m'),
						erp_products.id
				), 0 ) as BeginPS,
				COALESCE (" . $this->db->dbprefix('products') . ".quantity, 0) - COALESCE (PCosts.Pquantity, 0) + COALESCE( PSales.Squantity, 0 )
					+ COALESCE (PCosts.Pquantity, 0) AS purchased,
				COALESCE( PSales.Squantity, 0 ) + COALESCE (
                        (
                            SELECT
                                SUM(si.quantity * ci.quantity)
                            FROM
                                ".$this->db->dbprefix('combo_items') . " ci
                            INNER JOIN erp_sale_items si ON si.product_id = ci.product_id
                            WHERE
                                ci.item_code = ".$this->db->dbprefix('products') . ".code
                        ),
                        0
                    ) as sold,
					COALESCE((
						COALESCE (erp_products.quantity, 0) - COALESCE (PCosts.Pquantity, 0) + COALESCE (PSales.Squantity, 0) + COALESCE (PCosts.Pquantity, 0)
					) - COALESCE (PSales.Squantity, 0) + COALESCE (
					(
						SELECT
							SUM(si.quantity * ci.quantity)
						FROM
							erp_combo_items ci
						INNER JOIN erp_sale_items si ON si.product_id = ci.product_id
						WHERE
							ci.item_code = erp_products. CODE
					),
					0
					), 0)
					AS balance", 
				FALSE)
				 ->from('products')
				 ->join($sp, 'products.id = PSales.product_id', 'left')
				 ->join($pp, 'products.id = PCosts.product_id', 'left')
				 ->join($spb, 'products.id = PSalesBegin.product_id', 'left')
                 ->join($ppb, 'products.id = PCostsBegin.product_id', 'left')
				 ->join('warehouses_products wp', 'products.id=wp.product_id', 'left')
				 ->join('categories', 'products.category_id=categories.id', 'left')
				 ->where('products.id', $id)
				 ->group_by("products.id");
		$q = $this->db->get();
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return false;		
	}
	
	public function getRoomByID($id){
		$this->db
			->select("id,floor,name,ppl_number,description, CASE WHEN status = 0 THEN 'Active' ELSE 'Close' END AS status")
            ->from("erp_suspended")
			->where("id", $id);
		$q = $this->db->get();
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return false;
	}
	
	public function getSalemanByID($id){
		$this->db
				->select('username, phone, sum(erp_sales.total) as sale_amount, sum(erp_sales.paid) as sale_paid, (sum(erp_sales.total) - sum(erp_sales.paid)) as balance')
				->from('users')
				->join('sales', 'sales.saleman_by = users.id')
				->where('users.id', $id);
		$q = $this->db->get();
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return false;
	}
	
	public function getPurchasesByID($id){
		$this->db
				->select($this->db->dbprefix('purchases') . ".date, reference_no, " . $this->db->dbprefix('warehouses') . ".name as wname, supplier, GROUP_CONCAT(" . $this->db->dbprefix('purchase_items') . ".product_name SEPARATOR '___') as iname, GROUP_CONCAT(ROUND(" . $this->db->dbprefix('purchase_items') . ".quantity) SEPARATOR '___') as iqty, grand_total, paid, (grand_total-paid) as balance, " . $this->db->dbprefix('purchases') . ".status", FALSE)
				->from('purchases')
				->join('purchase_items', 'purchase_items.purchase_id=purchases.id', 'left')
				->join('warehouses', 'warehouses.id=purchases.warehouse_id', 'left')
				->where('purchases.id', $id)
                ->group_by('purchases.id')
                ->order_by('purchases.date desc');
		$q = $this->db->get();
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return false;
	}
	
	public function getPaymentsByID($id){
		$this->db
				->select($this->db->dbprefix('payments') . ".id as idd, ". $this->db->dbprefix('sales') . ".suspend_note as noted, ". $this->db->dbprefix('payments'). ".date, " . $this->db->dbprefix('payments') . ".reference_no as payment_ref, " . $this->db->dbprefix('sales') . ".reference_no as sale_ref, " . $this->db->dbprefix('purchases') . ".reference_no as purchase_ref, " . $this->db->dbprefix('payments') . ".note,payments.paid_by,amount, payments.type")
                ->from('payments')
                ->join('sales', 'payments.sale_id=sales.id', 'left')
                ->join('purchases', 'payments.purchase_id=purchases.id', 'left')
				->where('payments.id', $id)
                ->group_by('payments.id');
		$q = $this->db->get();
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return false;
	}
	
	public function getSaleDiscountByID($id)
	{
		$this->db->select('sales.date, sale_items.product_code, sale_items.product_name, sales.customer, products.cost, sale_items.unit_price ,sale_items.quantity, sale_items.discount')
				 ->from('sale_items')
				 ->join('sales', 'sales.id = sale_items.sale_id', 'left')
				 ->join('products', 'products.id = sale_items.product_id', 'left')
				 ->where('sale_items.discount <> 0 and sales.id = '.$id.' ');
		$q = $this->db->get();
		if($q->num_rows() > 0){
			return $q->row();
		}
		return false;
	}
	
	public function getProjectsByID($id){
		$this->db
				->select($this->db->dbprefix('companies') . ".id as idd, company, name, phone, email, count(" . $this->db->dbprefix('sales') . ".id) as total, COALESCE(sum(" . $this->db->dbprefix('sales') . ".grand_total), 0) as total_amount, (COALESCE(sum(" . $this->db->dbprefix('sales') . ".grand_total), 0) * (" . $this->db->dbprefix('companies') . ".cf6/100)) as total_earned, COALESCE(sum(paid), 0) as paid, ( COALESCE(sum(grand_total), 0) - COALESCE(sum(paid), 0)) as balance", FALSE)
                ->from("companies")
                ->join('sales', 'sales.biller_id=companies.id')
                ->where('companies.group_name', 'biller')
                ->group_by('companies.id');
		$q = $this->db->get();
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return false;
	}
	
	public function getSupplierByID($id){
		$this->db
				->select($this->db->dbprefix('companies') . ".id as idd, company, name, phone, email, count(" . $this->db->dbprefix('purchases') . ".id) as total, COALESCE(sum(grand_total), 0) as total_amount, COALESCE(sum(paid), 0) as paid, ( COALESCE(sum(grand_total), 0) - COALESCE(sum(paid), 0)) as balance", FALSE)
                ->from("companies")
                ->join('purchases', 'purchases.supplier_id=companies.id')
                ->where(array('companies.group_name'=> 'supplier', 'companies.id'=> $id))
                ->group_by('companies.id');
		$q = $this->db->get();
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return false;
	}
	
	public function getCustomersByID($id){
		$this->db
				->select($this->db->dbprefix('companies') . ".id as idd, company, name, phone, email, count(" . $this->db->dbprefix('sales') . ".id) as total, COALESCE(sum(grand_total), 0) as total_amount, COALESCE(sum(paid), 0) as paid, ( COALESCE(sum(grand_total), 0) - COALESCE(sum(paid), 0)) as balance", FALSE)
                ->from("companies")
                ->join('sales', 'sales.customer_id=companies.id')
                ->where('companies.id', $id)
                ->group_by('companies.id');
		$q = $this->db->get();
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return false;
	}
	
	public function getProfitByID($id){
		$this->db
				->select("erp_sales.id, date, reference_no, suspend_note, biller, customer, grand_total, paid, (grand_total-paid) as balance,
				COALESCE (
						(
							SELECT
								CASE
							WHEN type <> 'combo' THEN
								(
									SELECT
										SUM(
											cost * erp_sale_items.quantity
										)
									FROM
										erp_sale_items
									INNER JOIN erp_products ON erp_products.id = erp_sale_items.product_id
									WHERE
										erp_sale_items.sale_id = erp_sales.id
								)
							ELSE
								(
									SELECT
										SUM(
											erp_products.cost * erp_sale_items.quantity
										) AS cost
									FROM
										erp_combo_items
									INNER JOIN erp_products ON erp_products.`code` = erp_combo_items.item_code
									WHERE
										erp_combo_items.product_id = erp_sale_items.product_id
								)
							END
							FROM
								erp_products
							WHERE
								erp_products.id = erp_sale_items.product_id
						),
						0
					) AS total_cost,
				COALESCE (
					COALESCE (
						(
							grand_total
						),
						0
					) - COALESCE (
						(
							SELECT
								SUM(cost * " . $this->db->dbprefix('sale_items') . ".quantity)
							FROM
								" . $this->db->dbprefix('sale_items') . "
							INNER JOIN " . $this->db->dbprefix('products') . " ON " . $this->db->dbprefix('products') . ".id = " . $this->db->dbprefix('sale_items') . ".product_id
							WHERE
								" . $this->db->dbprefix('sale_items') . ".sale_id = " . $this->db->dbprefix('sales') . ".id
						),
						0
					)
				) AS profit, payment_status", FALSE)
				->from('sales')
				->join('sale_items', 'sale_items.sale_id=sales.id', 'left')
				->join('warehouses', 'warehouses.id=sales.warehouse_id', 'left')
				->join('companies', 'companies.id=sales.customer_id','left')                
				->join('customer_groups','customer_groups.id=companies.customer_group_id','left')
				->where('erp_sales.id', $id)
				->group_by('sales.id');
		$q = $this->db->get();
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return false;
	}
	
	public function getSalesByID($id){
		$this->db
				->select("erp_sales.id, date, reference_no, biller, customer,
									GROUP_CONCAT(" . $this->db->dbprefix('sale_items') . ".product_name SEPARATOR '\n') as iname, 
									GROUP_CONCAT(ROUND(".$this->db->dbprefix('sale_items') . ".quantity) SEPARATOR '\n') as iqty, 
									grand_total, 
									paid, 
									(grand_total-paid) as balance, 
									payment_status", FALSE)
				->from('sales')
				->join('sale_items', 'sale_items.sale_id=sales.id', 'left')
				->join('warehouses', 'warehouses.id=sales.warehouse_id', 'left')
				->join('companies', 'companies.id=sales.customer_id','left')                
				->join('customer_groups','customer_groups.id=companies.customer_group_id','left')
				->where('erp_sales.id', $id)
				->group_by('sales.id');
		$q = $this->db->get();
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return false;
	}
	
	public function getSalesExportByID($id){
		$this->db
				->select("erp_sales.id, date, reference_no, biller, customer,
							GROUP_CONCAT(CONCAT(" . $this->db->dbprefix('sale_items') . ".product_name, '(', " . $this->db->dbprefix('sale_items') . ".product_code , ')') SEPARATOR '\n') as iname, 
							GROUP_CONCAT(CONCAT((ROUND(".$this->db->dbprefix('sale_items') . ".quantity)), '(', " . $this->db->dbprefix('sale_items') . ".unit_price , ')') SEPARATOR '\n') as iqty, 
							GROUP_CONCAT(" . $this->db->dbprefix('products') . ".cost SEPARATOR '\n') as icost, 
							grand_total, paid, 
							(grand_total-paid) as balance, 
							payment_status, 
							SUM(".$this->db->dbprefix('sale_items') . ".quantity) as total_qty", FALSE)
				->from('sales')
				->join('sale_items', 'sale_items.sale_id=sales.id', 'left')
				->join('products', 'products.id = sale_items.product_id', 'left')
				->join('warehouses', 'warehouses.id=sales.warehouse_id', 'left')
				->join('companies', 'companies.id=sales.customer_id','left')                
				->join('customer_groups','customer_groups.id=companies.customer_group_id','left')
				->where('erp_sales.id', $id)
				->group_by('sales.id');
		$q = $this->db->get();
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return false;
	}
	
	public function getCategoryByID($id){
		$pp = "( SELECT pp.category_id as category, pi.product_id, SUM( pi.quantity ) purchasedQty, SUM( pi.net_unit_cost * pi.quantity ) totalPurchase from " . $this->db->dbprefix('products') . " pp
                left JOIN " . $this->db->dbprefix('purchase_items') . " pi on pp.id = pi.product_id 
                group by pp.category_id
                ) PCosts";
            $sp = "( SELECT sp.category_id as category, si.product_id, SUM( si.quantity ) soldQty, SUM( si.subtotal ) totalSale from " . $this->db->dbprefix('products') . " sp
                left JOIN " . $this->db->dbprefix('sale_items') . " si on sp.id = si.product_id 
                group by sp.category_id 
                ) PSales";
				
		$this->db
                ->select($this->db->dbprefix('categories') . ".id as cidd, " .$this->db->dbprefix('categories') . ".code, " . $this->db->dbprefix('categories') . ".name,
                    SUM( COALESCE( PCosts.purchasedQty, 0 ) ) as PurchasedQty,
                    SUM( COALESCE( PSales.soldQty, 0 ) ) as SoldQty,
                    SUM( COALESCE( PCosts.totalPurchase, 0 ) ) as TotalPurchase,
                    SUM( COALESCE( PSales.totalSale, 0 ) ) as TotalSales,
                    (SUM( COALESCE( PSales.totalSale, 0 ) )- SUM( COALESCE( PCosts.totalPurchase, 0 ) ) ) as Profit", FALSE)
                ->from('categories')
                ->join($sp, 'categories.id = PSales.category', 'left')
                ->join($pp, 'categories.id = PCosts.category', 'left')
				->where('categories.id', $id)
				->group_by('categories.id');
		$q = $this->db->get();
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return false;
	}
	
	public function getWarehouseByID($id){
		$this->db->select('id, code, name, quantity');
		$this->db->from('products');
		$this->db->where('id', $id);
		$q = $this->db->get();
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return false;		
	}
	
	public function getProductByID($id){
		$pp = "( SELECT 
					pi.date as date, 
					pi.product_id, 
					pi.purchase_id, 
					COALESCE(SUM(CASE WHEN pi.purchase_id <> 0 THEN (pi.quantity*(CASE WHEN ppv.qty_unit <> 0 THEN ppv.qty_unit ELSE 1 END)) ELSE 0 END),0) as purchasedQty, 
					SUM(pi.quantity_balance) as balacneQty, 
					SUM((CASE WHEN pi.option_id <> 0 THEN ppv.cost ELSE pi.net_unit_cost END) * pi.quantity_balance ) balacneValue, 
					SUM( pi.unit_cost * (CASE WHEN pi.purchase_id <> 0 THEN pi.quantity ELSE 0 END) ) totalPurchase
					FROM {$this->db->dbprefix('purchase_items')} pi 
					LEFT JOIN {$this->db->dbprefix('purchases')} p 
					ON p.id = pi.purchase_id
					LEFT JOIN " . $this->db->dbprefix('product_variants') . " ppv 
					ON ppv.id=pi.option_id ".$where_purchase." 
					WHERE pi.status <> 'ordered'
					GROUP BY pi.product_id ) PCosts";
		$sp = "( SELECT 
					si.product_id, 
					SUM( si.quantity*(CASE WHEN pv.qty_unit <> 0 THEN pv.qty_unit ELSE 1 END)) soldQty, 
					SUM( si.subtotal ) totalSale, 
					s.date as sdate FROM " . $this->db->dbprefix('sales') . " s 
					INNER JOIN " . $this->db->dbprefix('sale_items') . " si 
					ON s.id = si.sale_id 
					LEFT JOIN " . $this->db->dbprefix('product_variants') . " pv 
					ON pv.id=si.option_id ".$where_sale." 
					GROUP BY si.product_id ) PSales";
		$this->db
                ->select($this->db->dbprefix('products') . ".id AS idd, " . $this->db->dbprefix('products') . ".code, " . $this->db->dbprefix('products') . ".name,
				COALESCE( PCosts.purchasedQty, 0 ) AS qpurchase, COALESCE( PCosts.totalPurchase, 0 ) AS ppurchased,
				COALESCE (PSales.soldQty, 0) + COALESCE (
                        (
                            SELECT
                                SUM(si.quantity * ci.quantity)
                            FROM
                                erp_combo_items ci
                            INNER JOIN erp_sale_items si ON si.product_id = ci.product_id
                            WHERE
                                ci.item_code = ".$this->db->dbprefix('products') . ".code
                        ),
                        0
                ) AS qsale,
                COALESCE (PSales.totalSale, 0) AS psold,
                (COALESCE( PSales.totalSale, 0 ) - COALESCE( PCosts.totalPurchase, 0 )) as Profit,
				COALESCE( PCosts.balacneQty, 0 ) as qbalance, COALESCE( PCosts.balacneValue, 0 ) as pbalance", FALSE)
                ->from('products')
                ->join($sp, 'products.id = PSales.product_id', 'left')
                ->join($pp, 'products.id = PCosts.product_id', 'left')				
				->join('warehouses_products wp', 'products.id=wp.product_id', 'left')
				->join('categories', 'products.category_id=categories.id', 'left')
				->where('products.id', $id)
				->group_by("products.id");
		$q = $this->db->get();
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return false;	
	}

    function getQuantityByID($id){
        $this->db
             ->select('code, name, quantity, alert_quantity')
             ->from('products')
             ->where('alert_quantity > quantity', NULL)
             ->where(array('track_quantity'=> 1, 'products.id' => $id));
        $q = $this->db->get();
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return false;    
    }

    function getRegisterByID($id){
        $this->db
             ->select("date, closed_at, CONCAT(" . $this->db->dbprefix('users') . ".first_name, ' ', " . $this->db->dbprefix('users') . ".last_name, '<br>', " . $this->db->dbprefix('users') . ".email) as user, cash_in_hand, CONCAT(total_cc_slips, ' (', total_cc_slips_submitted, ')') as c_slips, CONCAT(total_cheques, ' (', total_cheques_submitted, ')') as cheques, CONCAT(total_cash, ' (', total_cash_submitted, ')') as cash, pos_register.note", FALSE)
             ->from("pos_register")
             ->where("pos_register.id", $id)
             ->join('users', 'users.id=pos_register.user_id', 'left');
        $q = $this->db->get();
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return false; 
    }
	
	function getDataReportDetail($id)
	{
	
		if($id)
		{
			
			$q = $this->db->query("
								SELECT
									`erp_sales`.`id`,
									erp_sale_items.product_id,
									`erp_categories`.`id` AS `categoryId`,
									`erp_categories`.`name` AS `categoryName`,
									CONCAT(
										erp_sale_items.product_name,
										' (',
										`erp_sale_items`.`product_code`,
										')'
									) AS productName,
									erp_sale_items.product_id as product_id,
									`erp_products`.`quantity` AS `stockInHand`,
									(SELECT SUM(quantity) from erp_return_items WHERE return_id=erp_return_sales.id) as total_return,
									SUM(erp_sale_items.quantity) AS saleQuantity,
									
									`erp_products`.`cost` AS `unitCost`,
									`erp_sale_items`.`unit_price` AS `unitPrice`,
									sum(
										(
											erp_sale_items.unit_price * erp_sale_items.quantity
										) - (
											CASE
											WHEN discount LIKE '%\%' THEN
												(
													erp_sale_items.unit_price * erp_sale_items.quantity
												) * SUBSTRING_INDEX(discount, '%', 1) / 100
											ELSE
												erp_sale_items.discount
											END
										)
									) AS revenue,
									(
										IFNULL(
											SUM(erp_sale_items.quantity) * erp_products.cost,
											0
										)
									) AS coms,
									sum(
										(
											(
												erp_sale_items.unit_price * erp_sale_items.quantity
											) - (
												CASE
												WHEN discount LIKE '%\%' THEN
													(
														erp_sale_items.unit_price * erp_sale_items.quantity
													) * SUBSTRING_INDEX(discount, '%', 1) / 100
												ELSE
													erp_sale_items.discount
												END
											)
										) - (
											IFNULL(
												erp_sale_items.quantity * erp_products.cost,
												0
											)
										)
									) AS profit,
									sum(
										CASE
										WHEN discount LIKE '%\%' THEN
											(
												erp_sale_items.unit_price * erp_sale_items.quantity
											) * SUBSTRING_INDEX(discount, '%', 1) / 100
										ELSE
											erp_sale_items.discount
										END
									) as total_discount
								FROM
									`erp_sales`
								JOIN `erp_sale_items` ON `erp_sales`.`id` = `erp_sale_items`.`sale_id`
								JOIN `erp_products` ON `erp_sale_items`.`product_id` = `erp_products`.`id`
								JOIN `erp_categories` ON `erp_products`.`category_id` = `erp_categories`.`id`
								LEFT JOIN erp_return_sales ON erp_return_sales.sale_id = erp_sales.id
								WHERE
									`erp_categories`.`id` = '".$id."'
								GROUP BY
									`erp_categories`.`id`,
									`erp_products`.`id`,
									erp_sale_items.unit_price,
									erp_sale_items.discount
			
							")->result();
			$row = '';
			$stockInHand = 0;
			$saleQuantity = 0;
			$unitCost = 0;
			$unitPrice = 0;
			$revenue = 0;
			$coms = 0;
			$profit = 0;
			$grand_discount = 0;
			$total_return = 0;
			foreach($q as $data_row){
				$stockInHand+=$data_row->stockInHand;
				$saleQuantity+=$data_row->saleQuantity;
				$unitCost+=$data_row->unitCost;
				$unitPrice+=$data_row->unitPrice;
				$revenue+=$data_row->revenue;
				$grand_discount+=$data_row->total_discount;
				$coms+=$data_row->coms;
				$profit+=$data_row->profit;
				$total_return += $data_row->total_return;
				$warehouses = $this->getAllWarehouses();				
				$row.='<tr>';					
					$row.='<td><input class="checkbox multi-select" name="val[]" value="'.$data_row->id.'" type="checkbox"/></td>';
					$row.='<td>'.$data_row->productName.'</td>';					
					$row.='<input type="hidden" value="'.$data_row->product_id.'">';
					foreach($warehouses as $warehouse){
						$warehouseQty = $this->getWHQty($data_row->product_id, $warehouse->id);
						$row.='<td>'.(($warehouseQty > 0)? $this->erp->formatQuantity($warehouseQty->wqty):$this->erp->formatQuantity(1)).'</td>';
					}
					$row.='<td>'.$this->erp->formatQuantity($data_row->saleQuantity) .'</td>';
					$row.='<td>'.$this->erp->formatMoney($data_row->unitCost).'</td>';
					$row.='<td>'.$this->erp->formatMoney($data_row->unitPrice) .'</td>';
					$row.='<td>'.$this->erp->formatMoney($data_row->total_discount) .'</td>';
					$row.='<td>'.$this->erp->formatMoney($data_row->total_return).'</td>';
					$row.='<td>'.$this->erp->formatMoney($data_row->revenue) .'</td>';										
				$row.='</tr>';			
			}
			
			$row.='<tr style="font-weight:bold;">';
					$row.='<td><input class="checkbox multi-select" name="val[]" value="'.$data_row->id.'" type="checkbox"/></td>';
					$row.='<td style="text-align:right;padding-right:10px;">'."Grand Total".'</td>';
					$row.='<input type="hidden" value="'.$data_row->product_id.'">';
					foreach($warehouses as $warehouse){
						$warehouseQty = $this->getWHQty($data_row->product_id, $warehouse->id);
						$row.='<td>'.(($warehouseQty > 0)? $this->erp->formatQuantity($warehouseQty):$this->erp->formatQuantity(1)).'</td>';
					}
					$row.='<td>'.$this->erp->formatQuantity($saleQuantity) .'</td>';
					$row.='<td>'.$this->erp->formatMoney($unitCost).'</td>';
					$row.='<td>'.$this->erp->formatMoney($unitPrice) .'</td>';
					$row.='<td>'.$this->erp->formatMoney($grand_discount) .'</td>';
					$row.='<td>'.$this->erp->formatMoney($total_return) .'</td>';
					$row.='<td>'.$this->erp->formatMoney($revenue) .'</td>';											
				$row.='</tr>';
			return $row;
		}else{
			return "Data Not Found";
		}
	}
	
	
	function getWarehouseQty($product_id){
		$this->db->select('erp_warehouses_products.quantity as wqty');
		$this->db->where('erp_warehouses_products.product_id',$product_id);
		$this->db->from('erp_warehouses_products');
		$result = $this->db->get();
		if($result->num_rows()>0){
			foreach($result->result() as $row){
				$data[] = $row;
			}
			return $data;
		}
		return false;
		
	}
	
	function getWHQty($product_id, $wh_id){
		$this->db->select('erp_warehouses_products.quantity as wqty');
		$this->db->where(array('erp_warehouses_products.product_id' => $product_id, 'erp_warehouses_products.warehouse_id' => $wh_id));
		$this->db->from('erp_warehouses_products');
		$result = $this->db->get();
		if($result->num_rows()>0){
			return $result->row();
		}
		return false;
		
	}
	
	function getCategoryName($category_id = NULL, $product_id = NULL, $start = NULL, $end = NULL, $biller_id = NULL){
		$this->db->select("categories.id,categories.name,sales.date");
		$this->db->from("sale_items");
		$this->db->join('products','products.id = sale_items.product_id');
		$this->db->join('categories','categories.id = products.category_id');
		$this->db->join('sales','sales.id = sale_items.sale_id');
		if($category_id) {
			$this->db->where('categories.id', $category_id);
		}
		if($product_id){
			$this->db->where('products.id', $product_id);
		}
		if($start && $end) {
			$this->db->where('sales.date >= ' . $start . ' AND sales.date <= ' . $end . ' ');
		}
		if($biller_id) {
			$this->db->where('sales.biller_id', $biller_id);
		}
		$this->db->group_by('categories.id');
		$q = $this->db->get();
		if($q->num_rows() > 0 ) {
			return $q->result();
		}
		return false;
	}
	
	function getCategory(){
		$q = $this->db->get('categories');
		if ($q->num_rows() > 0) {
            foreach (($q->result()) as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return FALSE;
	}
	function getProductName(){
		$q = $this->db->get('products');
		if ($q->num_rows() > 0) {
            foreach (($q->result()) as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return FALSE;
	}
	
	function getExportSaleDetail($id){
		$this->db->select("
		sales.id,
		categories.id as categoryId,
		categories.name as categoryName,
		CONCAT(erp_sale_items.product_name,' (',erp_sale_items.product_code,')') as productName,
		products.quantity as stockInHand,
		SUM(erp_sale_items.quantity) AS saleQuantity,
		products.cost as unitCost,
		products.price as unitPrice,
		sum(
			(
				erp_sale_items.unit_price * erp_sale_items.quantity
			) - (
				CASE
				WHEN discount LIKE '%\%' THEN
					(
						erp_sale_items.unit_price * erp_sale_items.quantity
					) * SUBSTRING_INDEX(discount, '%', 1) / 100
				ELSE
					erp_sale_items.discount
				END
			)
		) AS revenue,		
		(
			IFNULL(
				SUM(erp_sale_items.quantity) * erp_products.cost,
				0
			)
		) AS coms,
		sum(
			(
				(
					erp_sale_items.unit_price * erp_sale_items.quantity
				) - (
					CASE
					WHEN discount LIKE '%\%' THEN
						(
							erp_sale_items.unit_price * erp_sale_items.quantity
						) * SUBSTRING_INDEX(discount, '%', 1) / 100
					ELSE
						erp_sale_items.discount
					END
				)
			) - (
				IFNULL(
					erp_sale_items.quantity * erp_products.cost,
					0
				)
			)
		) AS profit");
        $this->db->from('sales');
        $this->db->join('sale_items', 'sales.id = sale_items.sale_id');
        $this->db->join('products', 'sale_items.product_id = products.id');        
        $this->db->join('categories', 'products.category_id = categories.id');
		$this->db->where('categories.id', $id);
        $this->db->group_by('categories.id');		
        $this->db->group_by('products.id');		
		$q = $this->db->get();
		if($q->num_rows() > 0 ) {
			return $q->result();
		}
		return false;
	}
	public function getAllCompanies($group_name) {
        $q = $this->db->get_where('companies', array('group_name' => $group_name));
        if ($q->num_rows() > 0) {
            foreach (($q->result()) as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return FALSE;
    }
	function getDataSaleDetailByInvoice($sale_id){
		if($start){
			$start_date = $start;
			$end_date = $end;
		}else{
			$start_date = date('Y-m-d').'00:00:00';
			$end_date = date('Y-m-d h:i:s');
		}
	if($sale_id){
		$this->db->select("sales.id, sales.date, sales.reference_no, sales.biller_id, CONCAT(erp_sale_items.product_code ,' - ', erp_sale_items.product_name) as product_name, erp_sale_items.quantity as qty, sale_items.unit_price as unit_price,sale_items.discount as dis, sale_items.subtotal as amount");
        $this->db->from('sales');
        $this->db->join('sale_items', 'sales.id = sale_items.sale_id');
        $this->db->join('products', 'sale_items.product_id = products.id');        
        $this->db->join('companies', 'companies.id = sales.biller_id');
       // $this->db->join('product_variants', 'sale_items.option_id = product_variants.id');
		$this->db->where('sales.id', $sale_id);		
		//$this->db->where('sales.date >= "'.$start_date.'" and sales.date <= "'.$end_date.'"');
        		
		$q = $this->db->get();		
        foreach($q->result() as $data_row){			
			$row.='<tr>';			
				$row.='<td colspan="2">'." ".'</td>';
				$row.='<td style="padding-left:20px;">'.$data_row->product_name .'</td>';
				$row.='<td>'.$this->erp->formatQuantity($data_row->qty).'</td>';
				$row.='<td>'.$this->erp->formatMoney($data_row->unit_price) .'</td>';
				$row.='<td>'.$data_row->dis .'</td>';
				$row.='<td>'.$this->erp->formatMoney($data_row->amount) .'</td>';															
			$row.='</tr>';			
		}		
		return $row;
	  }
	else		
		return "Data Not Found";
	}
	function searchByBiller($biller = NULL){
		$this->db->select("companies.id, companies.group_name, sales.reference_no, sales.date");
		$this->db->from("sales");	
		$this->db->join('companies','companies.id = sales.biller_id');
		if($biller) {
			$this->db->where(array('group_name' => 'biller','sales.biller_id' => $biller));
		}		
		$q = $this->db->get();
		if($q->num_rows() > 0 ) {
			return $q->result();
		}
		return false;
	}
	function getSearchInvoice($biller){
		$post = $this->input->post();
		$sql = "SELECT
					`erp_sales`.*, `product_name`,
					`product_code`,
					sum(erp_sale_items.quantity) AS quantity,
					sum(erp_sale_items.unit_price) AS unit_price,
					sum(item_discount) AS item_discount
				FROM
					`erp_sales`
				LEFT JOIN `erp_sale_items` ON `erp_sale_items`.`sale_id` = `erp_sales`.`id`
				WHERE
					`erp_sales`.`biller_id` = {$biller}
				GROUP BY
					`reference_no`,
					`biller_id`";
		$result = $this->db->query($sql);	
		$html = "";
		$total_quantity = 0; $total_price = 0; $total_discount_item = 0; $total_amount = 0;
        foreach($result->result() as $row){
        	$total_quantity += $row->quantity;
        	$total_price += $row->unit_price;
        	$total_discount_item += ($row->item_discount * $row->unit_price / 100);
        	$total_amount += $row->total;
			$html.='<tr>';
				$html.='<td><input class="checkbox checkth" type="checkbox" name="check"/></td>';				
				$html.='<td>'.$row->date.'</td>';
				$html.='<td>'.$row->reference_no.'</td>';
				$html.='<td>'.$row->total_items .'</td>';	
				$html.='<td class="right">'.$row->quantity .'</td>';
				$html.='<td class="right">'.$row->unit_price .'</td>';
				$html.='<td class="right">'.($row->item_discount * $row->unit_price / 100) .'</td>';
				$html.='<td class="right">'.$this->erp->formatMoney($row->total).'</td>';															
			$html.='</tr>';			
		}
		$result = array(
			'html' => $html, 
			'total_quantity' => $total_quantity,
			'total_price' => $total_price,
			'total_discount_item' => $total_discount_item,
			'total_amount' => $total_amount,
		);	
		return $result;
	}
	function getInvoice($start = NULL, $end = NULL){
		$start = $this->erp->fld(date('d/m/Y'));
		$end = $this->erp->fld(date('d/m/Y h:i:s'));
		if($start){
			$start_date = $start;
			$end_date = $end;
		}else{
			$start_date = $this->erp->fld(date('d/m/Y'));
			$end_date = $this->erp->fld(date('d/m/Y h:i:s'));
		}
		$this->db->select("sales.id, sales.reference_no, sales.biller_id, sales.total")->from("sales");		
		$this->db->where('sales.date >= "'.$start_date.'" and sales.date <= "'.$end_date.'"');
		$q = $this->db->get();
		if($q->num_rows() > 0 ) {
			return $q->result();
		}
		return false;
	}
	
	public function getSalesOrder($customer_id)
    {
        $this->db->from('sale_order')->where('customer_id', $customer_id);
        return $this->db->count_all_results();
    }
	
	public function getWarehouse(){
		$q = $this->db->get('erp_warehouses');
		if($q->num_rows() > 0 ) {
			foreach($q->result() as $row){
				$data[] = $row;
			}
			return $data;
		}
		return false;
	}
	public function getCategoryByProduct(){
		$this->db->select('erp_categories.id as cid,erp_categories.code as ccode,erp_categories.name as cname,erp_subcategories.id as subid,erp_subcategories.code as scode,erp_subcategories.name as sname')->from('erp_categories')->join('erp_subcategories','erp_subcategories.category_id=erp_categories.id','left');
		$q = $this->db->get();
		if($q->num_rows() > 0 ) {
			foreach($q->result() as $row){
				$data[] = $row;
			}
			return $data;
		}
		return false;
	}
	public function getProductByCategoryAndWarehouse(){
		$this->db->select('erp_products.*,erp_warehouses_products.warehouse_id as wid,erp_categories.id as cid,erp_categories.code as ccode,erp_categories.name as cname,erp_subcategories.id as subid,erp_subcategories.code as scode,erp_subcategories.name as sname')->from('erp_products')
		->join('erp_warehouses_products','erp_warehouses_products.product_id=erp_products.id','left')
		->join('erp_categories','erp_categories.id=erp_products.category_id','left')
		->join('erp_subcategories','erp_subcategories.id=erp_products.subcategory_id','left');
		
		$q = $this->db->get();
		if($q->num_rows() > 0 ) {
			foreach($q->result() as $row){
				$data[] = $row;
			}
			return $data;
		}
		return false;
	}
	public function getPurchaseByProductID(){
		$this->db->select('erp_purchase_items.*,erp_purchases.id as pur_id,erp_purchases.supplier,erp_purchases.reference_no,erp_companies.company,erp_purchases.warehouse_id,erp_products.cost as pcost,erp_products.quantity as pqty,erp_products.unit')->from('erp_purchase_items')
		->join('erp_purchases','erp_purchases.id=erp_purchase_items.purchase_id','left')
		->join('erp_products','erp_products.id=erp_purchase_items.product_id','left')
		->join('erp_companies','erp_companies.id=erp_purchases.biller_id','left');
		//->group_by('pur_id');
		$q = $this->db->get();
		if($q->num_rows() > 0 ) {
			foreach($q->result() as $row){
				$data[] = $row;
			}
			return $data;
		}
		return false;
	}
	/*
	public function getWarehousesInventoryValuation($warehouse_id,$category_id,$product_id,$stockType,$stock_in_out,$from_date,$to_date,$reference_no){
		$this->db->select('warehouses.code, warehouses.name AS warehouse, warehouse_id');
		$this->db->join('warehouses', 'warehouses.id = warehouse_id');
		if($warehouse_id){
			$this->db->where('warehouse_id', $warehouse_id);
		}
		if($category_id){
			$this->db->where('category_id', $category_id);
		}
		if($product_id){
			$this->db->where('product_id', $product_id);
		}
		if($stockType){
			$this->db->where('type', $stockType);
		}
		if($stock_in_out){
			if($stock_in_out=='in'){
				$this->db->where('quantity >',0);
			}else{
				$this->db->where('quantity <',0);
			}
		}
		if($reference_no){
			$this->db->where('reference_no', $reference_no);
		}
		if($from_date && $to_date){
			$from_date = date('Y-m-d',strtotime($from_date)).' 00:00:00';
			$to_date   = date('Y-m-d',strtotime($to_date)).' 00:00:00';
			$this->db->where('date >="'.$from_date.'" AND date <="'.$to_date.'"');
		}
		
		
		$this->db->group_by('warehouse_id');
		$q = $this->db->get('inventory_valuation_details');
		if($q->num_rows() > 0 ) {
			foreach($q->result() as $row){
				$data[] = $row;
			}
			return $data;
		}
		return false;
	}
	
	public function getCategoriesInventoryValuationByWarehouse($warehouse_id,$category_id,$product_id,$stockType,$stock_in_out,$from_date,$to_date,$reference_no){
		$this->db->select('category_id, categories.name AS category_name');
		$this->db->join('categories', 'categories.id = inventory_valuation_details.category_id');
		if($warehouse_id){
			$this->db->where('warehouse_id', $warehouse_id);
		}
		if($category_id){
			$this->db->where('category_id', $category_id);
		}
		if($product_id){
			$this->db->where('product_id', $product_id);
		}
		if($stockType){
			$this->db->where('type', $stockType);
		}
		if($stock_in_out){
			if($stock_in_out=='in'){
				$this->db->where('quantity >',0);
			}else{
				$this->db->where('quantity <',0);
			}
		}
		if($reference_no){
			$this->db->where('reference_no', $reference_no);
		}
		if($from_date && $to_date){
			$from_date = date('Y-m-d',strtotime($from_date)).' 00:00:00';
			$to_date   = date('Y-m-d',strtotime($to_date)).' 00:00:00';
			$this->db->where('date >="'.$from_date.'" AND date <="'.$to_date.'"');
		}
		$this->db->group_by('category_id');
		$q = $this->db->get('inventory_valuation_details');
		if($q->num_rows() > 0 ) {
			foreach($q->result() as $row){
				$data[] = $row;
			}
			return $data;
		}
		return false;
	}
	
	public function getProductsInventoryValuationByWhCat($warehouse_id,$category_id,$product_id,$stockType,$stock_in_out,$from_date,$to_date,$reference_no){
		$this->db->select('product_id, product_code, product_name');
		$this->db->where('warehouse_id', $warehouse_id);
		if($warehouse_id){
			$this->db->where('warehouse_id', $warehouse_id);
		}
		if($category_id){
			$this->db->where('category_id', $category_id);
		}
		if($product_id){
			$this->db->where('product_id', $product_id);
		}
		if($stockType){
			$this->db->where('type', $stockType);
		}
		if($stock_in_out){
			if($stock_in_out=='in'){
				$this->db->where('quantity >',0);
			}else{
				$this->db->where('quantity <',0);
			}
		}
		if($reference_no){
			$this->db->where('reference_no', $reference_no);
		}
		if($from_date && $to_date){
			
			$from_date = date('Y-m-d',strtotime($from_date)).' 00:00:00';
			$to_date   = date('Y-m-d',strtotime($to_date)).' 00:00:00';
			$this->db->where('date >= "'.$from_date.'" AND date <= "'.$to_date.'"');
		}
		$this->db->group_by('product_id');
		$q = $this->db->get('inventory_valuation_details');
		if($q->num_rows() > 0 ) {
			foreach($q->result() as $row){
				$data[] = $row;
			}
			return $data;
		}
		return false;
	}
	
	public function getProductsInventoryValuationByProduct($warehouse_id,$category_id,$product_id,$stockType,$stock_in_out,$from_date,$to_date,$reference_no){
		$this->db->select('inventory_valuation_details.*, companies.name AS biller_name');
		$this->db->join('companies', 'companies.id = inventory_valuation_details.biller_id', 'left');
		if($warehouse_id){
			$this->db->where('warehouse_id', $warehouse_id);
		}
		if($category_id){
			$this->db->where('category_id', $category_id);
		}
		if($product_id){
			$this->db->where('product_id', $product_id);
		}
		if($stockType){
			$this->db->where('type', $stockType);
		}
		if($stock_in_out){
			if($stock_in_out=='in'){
				$this->db->where('quantity >',0);
			}else{
				$this->db->where('quantity <',0);
			}
		}
		if($reference_no){
			$this->db->where('reference_no', $reference_no);
		}
		if($from_date && $to_date){
			$from_date = date('Y-m-d',strtotime($from_date)).' 00:00:00';
			$to_date   = date('Y-m-d',strtotime($to_date)).' 00:00:00';
			$this->db->where('date >="'.$from_date.'" AND date<="'.$to_date.'"');
		}
		$q = $this->db->get('inventory_valuation_details');
		if($q->num_rows() > 0 ) {
			foreach($q->result() as $row){
				$data[] = $row;
			}
			return $data;
		}
		return false;
	}
	*/
	
		public function getWarehousesInventoryValuation($warehouse_id,$category_id,$product_id,$stockType,$stock_in_out,$from_date,$to_date,$reference_no){
		$this->db->select('warehouses.code, warehouses.name AS warehouse, warehouse_id');
		$this->db->join('warehouses', 'warehouses.id = warehouse_id');
		if($warehouse_id){
			$this->db->where('warehouse_id', $warehouse_id);
		}
		if($category_id){
			$this->db->where('category_id', $category_id);
		}
		if($product_id){
			$this->db->where('product_id', $product_id);
		}
		if($stockType){
			$this->db->where('type', $stockType);
		}
		if($stock_in_out){
			if($stock_in_out=='in'){
				$this->db->where('quantity >',0);
			}else{
				$this->db->where('quantity <',0);
			}
		}
		if($reference_no){
			$this->db->where('reference_no', $reference_no);
		}
		if($from_date && $to_date){
			$from_date = date('Y-m-d',strtotime($from_date)).' 00:00:00';
			$to_date   = date('Y-m-d',strtotime($to_date)).' 00:00:00';
			$this->db->where('date >="'.$from_date.'" AND date <="'.$to_date.'"');
		}
		
		
		$this->db->group_by('warehouse_id');
		$q = $this->db->get('inventory_valuation_details');
		if($q->num_rows() > 0 ) {
			foreach($q->result() as $row){
				$data[] = $row;
			}
			return $data;
		}
		return false;
	}
	
	public function getCategoriesInventoryValuationByWarehouse($warehouse_id,$category_id,$product_id,$stockType,$stock_in_out,$from_date,$to_date,$reference_no){
		$this->db->select('category_id, categories.name AS category_name');
		$this->db->join('categories', 'categories.id = inventory_valuation_details.category_id');
		if($warehouse_id){
			$this->db->where('warehouse_id', $warehouse_id);
		}
		if($category_id){
			$this->db->where('category_id', $category_id);
		}
		if($product_id){
			$this->db->where('product_id', $product_id);
		}
		if($stockType){
			$this->db->where('type', $stockType);
		}
		if($stock_in_out){
			if($stock_in_out=='in'){
				$this->db->where('quantity >',0);
			}else{
				$this->db->where('quantity <',0);
			}
		}
		if($reference_no){
			$this->db->where('reference_no', $reference_no);
		}
		if($from_date && $to_date){
			$from_date = date('Y-m-d',strtotime($from_date)).' 00:00:00';
			$to_date   = date('Y-m-d',strtotime($to_date)).' 00:00:00';
			$this->db->where('date >="'.$from_date.'" AND date <="'.$to_date.'"');
		}
		$this->db->group_by('category_id');
		$q = $this->db->get('inventory_valuation_details');
		if($q->num_rows() > 0 ) {
			foreach($q->result() as $row){
				$data[] = $row;
			}
			return $data;
		}
		return false;
	}
	
	public function getProductsInventoryValuationByWhCat($warehouse_id,$category_id,$product_id,$stockType,$stock_in_out,$from_date,$to_date,$reference_no){
		$this->db->select('product_id, product_code, product_name');
		$this->db->where('warehouse_id', $warehouse_id);
		
		if($category_id){
			$this->db->where('category_id', $category_id);
		}
		if($product_id){
			$this->db->where('product_id', $product_id);
		}
		if($stockType){
			$this->db->where('type', $stockType);
		}
		if($stock_in_out){
			if($stock_in_out=='in'){
				$this->db->where('quantity >',0);
			}else{
				$this->db->where('quantity <',0);
			}
		}
		if($reference_no){
			$this->db->where('reference_no', $reference_no);
		}
		if($from_date && $to_date){
			
			$from_date = date('Y-m-d',strtotime($from_date)).' 00:00:00';
			$to_date   = date('Y-m-d',strtotime($to_date)).' 00:00:00';
			$this->db->where('date >= "'.$from_date.'" AND date <= "'.$to_date.'"');
		}
		$this->db->group_by('product_id');
		$q = $this->db->get('inventory_valuation_details');
		if($q->num_rows() > 0 ) {
			foreach($q->result() as $row){
				$data[] = $row;
			}
			return $data;
		}
		return false;
	}
	
	public function getProductsInventoryValuationByProduct($warehouse_id,$category_id,$product_id,$stockType,$stock_in_out,$from_date,$to_date,$reference_no){
		$this->db->select('inventory_valuation_details.*, companies.name AS biller_name');
		$this->db->join('companies', 'companies.id = inventory_valuation_details.biller_id', 'left');
		if($warehouse_id){
			$this->db->where('warehouse_id', $warehouse_id);
		}
		if($category_id){
			$this->db->where('category_id', $category_id);
		}
		if($product_id){
			$this->db->where('product_id', $product_id);
		}
		if($stockType){
			$this->db->where('type', $stockType);
		}
		if($stock_in_out){
			if($stock_in_out=='in'){
				$this->db->where('quantity >',0);
			}else{
				$this->db->where('quantity <',0);
			}
		}
		if($reference_no){
			$this->db->where('reference_no', $reference_no);
		}
		if($from_date && $to_date){
			$from_date = date('Y-m-d',strtotime($from_date)).' 00:00:00';
			$to_date   = date('Y-m-d',strtotime($to_date)).' 00:00:00';
			$this->db->where('date >="'.$from_date.'" AND date<="'.$to_date.'"');
		}
		$q = $this->db->get('inventory_valuation_details');
		if($q->num_rows() > 0 ) {
			foreach($q->result() as $row){
				$data[] = $row;
			}
			return $data;
		}
		return false;
	}
	
	public function getAllCategories(){
		$q = $this->db->get_where('categories');
		if($q->num_rows()>0){
			foreach($q->result() as $row){
				$data[] = $row;
			}
			return $data;
		}
		return false;
	}
	
	public function getAllProducts(){
		$q = $this->db->get_where('products');
		if($q->num_rows()>0){
			foreach($q->result() as $row){
				$data[] = $row;
			}
			return $data;
		}
		return false;
	}
	
	public function getCustomerProducts() {
		$this->db
			->select('products.id as id, products.code, products.name, products.quantity, products.unit, products.cost')
			->from('products');
		$q = $this->db->get();
        if ($q->num_rows() > 0) {
            foreach (($q->result()) as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return FALSE;
	}			
	
}
