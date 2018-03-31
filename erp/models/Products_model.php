<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Products_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function insertConvert($data)
    {
        if ($this->db->insert('convert', $data)) {
            $convert_id = $this->db->insert_id();
			
			if ($this->site->getReference('con', $data['biller_id']) == $data['reference_no']) {
				$this->site->updateReference('con', $data['biller_id']);
			}
            return $convert_id;
        }
    }
	
	public function updateConvert($id, $data) {
        if ($this->db->update('convert', $data, array('id' => $id))) {
            return true;
        }
        return false;
	}
	
	public function getConvertByID($id) {
        $this->db->select("convert.id, 
					convert.date, convert.reference_no, 
					SUM(" . $this->db->dbprefix('convert_items') . ".quantity) AS Quantity, products.cost, convert_items.product_name, convert.noted, 
					CONCAT(" . $this->db->dbprefix('users') . ".first_name, ' ', " . $this->db->dbprefix('users') . ".last_name) as user, convert.created_by, warehouses.id as warehouse_id, warehouses.name as war_name, convert.biller_id, convert.bom_id")
                ->join('users', 'users.id=convert.created_by', 'left')
                ->join('convert_items', 'convert.id=convert_items.convert_id', 'left')
                ->join('products', 'convert_items.product_id = products.id')
                ->join('warehouses', 'convert.warehouse_id = warehouses.id');
        $q = $this->db->get_where('convert', array('convert.id' => $id, 'convert_items.status =' => 'add'), 1);
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return FALSE;
    }
	
	public function ConvertDeduct($id)
    {
        $this->db->select('product_name, product_code,'.$this->db->dbprefix('convert_items').'.quantity AS Cquantity,'.$this->db->dbprefix('convert_items').'.cost AS Ccost,'.$this->db->dbprefix('products').'.cost AS Pcost, product_variants.name as variant, product_variants.qty_unit')
				->join('products', 'products.id=convert_items.product_id', 'left')
				->join('product_variants', 'product_variants.id=convert_items.option_id', 'left');
		$q = $this->db->get_where('convert_items', array('convert_id' => $id, 'status' => 'deduct'));
        if ($q->num_rows() > 0) {
            return $q->result();
        }
        return FALSE;
    }
	
	public function ConvertAdd($id)
    {
       $this->db->select('product_name, product_code,'.
			$this->db->dbprefix('convert_items').'.quantity AS Cquantity,'.
			$this->db->dbprefix('convert_items').'.cost AS Ccost,'.
			$this->db->dbprefix('products').'.cost AS Pcost, product_variants.name as variant, product_variants.qty_unit')
				->join('products', 'products.id=convert_items.product_id', 'left')
				->join('product_variants', 'product_variants.id=convert_items.option_id', 'left');
		$q = $this->db->get_where('convert_items', array('convert_id' => $id, 'status' => 'add'));
        if ($q->num_rows() > 0) {
            return $q->result();
        }
        return FALSE;
    }
	
	public function convertHeader($id)
	{
		$this->db->select('convert.*,users.username,warehouses.name')
			 ->join('users', 'users.id = convert.created_by', 'left')
             ->join('warehouses', 'warehouses.id = convert.warehouse_id', 'left');
		$q = $this->db->get_where("convert", array('convert.id' => $id));
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return FALSE;
	}
	
	public function getConvert_ItemByID($id)
    {
		$this->db->select('convert_items.id, 
							convert_items.convert_id, 
							convert_items.product_id, 
							convert_items.product_code, 
							convert_items.product_name, 
							convert_items.quantity, 
							convert_items.cost, 
							convert_items.status,
							convert_items.option_id'
						);
		$q = $this->db->get_where("convert_items", array('convert_id' => $id));
        if ($q->num_rows() > 0) {
            foreach (($q->result()) as $row) {
                $data[] = $row;
            }
            return $data;
        }
    }
	
	public function deleteConvert($id)
    {
        if ($this->db->delete('convert', array('id' => $id))) {
            return true;
        }
        return FALSE;
    }
	
	public function deleteConvert_items($id)
    {
        if ($this->db->delete('convert_items', array('convert_id' => $id))) {
            return true;
        }
        return FALSE;
    }
	public function deleteConvert_itemsByPID($id, $product_id)
    {
        if ($this->db->delete('convert_items', array('convert_id' => $id, 'product_id' => $product_id))) {
            return true;
        }
        return FALSE;
    }

    public function getAllProducts()
    {
        $q = $this->db->get('products');
        if ($q->num_rows() > 0) {
            foreach (($q->result()) as $row) {
                $data[] = $row;
            }

            return $data;
        }
    }
	public function getCategoryProducts($category_id)
    {
        $q = $this->db->get_where('products', array('category_id' => $category_id));
        if ($q->num_rows() > 0) {
            foreach (($q->result()) as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return FALSE;
    }

    public function getSubCategoryProducts($subcategory_id)
    {
        $q = $this->db->get_where('products', array('subcategory_id' => $subcategory_id));
        if ($q->num_rows() > 0) {
            foreach (($q->result()) as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return FALSE;
    }
    
	public function getProductWithCategory($id)
    {
        $this->db->select($this->db->dbprefix('products') . '.*, ' . $this->db->dbprefix('categories') . '.name as category')
        ->join('categories', 'categories.id=products.category_id', 'left');
        $q = $this->db->get_where('products', array('products.id' => $id), 1);
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return FALSE;
    }

    public function getProductOptions($pid)
    {
		$this->db->order_by('qty_unit', 'ASC');
        $q = $this->db->get_where('product_variants', array('product_id' => $pid));
        if ($q->num_rows() > 0) {
            foreach (($q->result()) as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return FALSE;
    }
	
	public function getQASuggestions($term, $warehouse_id, $limit = 20)
    {
        $this->db->select('' . $this->db->dbprefix('products') . '.id, code, ' . 
							$this->db->dbprefix('products') . '.name as name, 
							(SELECT COALESCE(quantity , 0) as qoh FROM erp_warehouses_products WHERE warehouse_id = '.$warehouse_id.' AND erp_warehouses_products.product_id = erp_products.id) as qoh')
				 ->where("type != 'combo' AND " . "(" . $this->db->dbprefix('products') . ".name LIKE '%" . $term . "%' OR code LIKE '%" . $term . "%' OR concat(" . $this->db->dbprefix('products') . ".name, ' (', code, ')') LIKE '%" . $term . "%')")
				->limit($limit);
        $q = $this->db->get('products');
        if ($q->num_rows() > 0) {
            foreach (($q->result()) as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
    }

    public function getProductOptionsWithWH($pid)
    {
        $this->db->select($this->db->dbprefix('product_variants') . '.*, ' . $this->db->dbprefix('warehouses') . '.name as wh_name, ' . $this->db->dbprefix('warehouses') . '.id as warehouse_id, ' . $this->db->dbprefix('warehouses_products_variants') . '.quantity as wh_qty, ' . $this->db->dbprefix('product_variants') . '.qty_unit, ('.$this->db->dbprefix('product_variants').'.cost * '.$this->db->dbprefix('product_variants').'.qty_unit) AS variant_cost ')
            ->join('warehouses_products_variants', 'warehouses_products_variants.option_id=product_variants.id', 'left')
            ->join('warehouses', 'warehouses.id=warehouses_products_variants.warehouse_id', 'left')
            ->group_by(array('' . $this->db->dbprefix('product_variants') . '.id', '' . $this->db->dbprefix('warehouses_products_variants') . '.warehouse_id'))
            ->order_by('product_variants.qty_unit DESC');
        $q = $this->db->get_where('product_variants', array('product_variants.product_id' => $pid, 'warehouses_products_variants.quantity !=' => NULL));
        if ($q->num_rows() > 0) {
            foreach (($q->result()) as $row) {
                $data[] = $row;
            }

            return $data;
        }
    }

    public function getProductComboItems($pid)
    {
        $this->db->select($this->db->dbprefix('products') . '.id as id, ' . $this->db->dbprefix('products') . '.code as code, ' . $this->db->dbprefix('combo_items') . '.quantity as qty, ' . $this->db->dbprefix('products') . '.name as name, ' . $this->db->dbprefix('combo_items') . '.unit_price as price, ' . $this->db->dbprefix('products') . '.cost as cost')->join('products', 'products.code=combo_items.item_code', 'left')->group_by('combo_items.id');
        $q = $this->db->get_where('combo_items', array('product_id' => $pid));
        if ($q->num_rows() > 0) {
            foreach (($q->result()) as $row) {
                $data[] = $row;
            }

            return $data;
        }
        return FALSE;
    }

    public function getProductByID($id)
    {
		$this->db->select('products.*,units.id as unit_id,units.name as unit');
        $this->db->where('products.id', $id)->join('units', 'products.unit=units.id', 'left');
		$q = $this->db->get('products');
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return FALSE;
    }

    public function has_purchase($product_id, $warehouse_id = NULL)
    {
        if($warehouse_id) { $this->db->where('warehouse_id', $warehouse_id); }
        $q = $this->db->get_where('purchase_items', array('product_id' => $product_id), 1);
        if ($q->num_rows() > 0) {
            return TRUE;
        }
        return FALSE;
    }

    public function getProductDetails($id)
    {
        $this->db->select($this->db->dbprefix('products') . '.code, ' . $this->db->dbprefix('products') . '.name, ' . $this->db->dbprefix('categories') . '.code as category_code, cost, price, quantity, alert_quantity')
            ->join('categories', 'categories.id=products.category_id', 'left');
        $q = $this->db->get_where('products', array('products.id' => $id), 1);
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return FALSE;
    }

    public function getProductDetail($id) {
	$this->db->select($this->db->dbprefix('products') . '.*, ' . $this->db->dbprefix('tax_rates') . '.code as tax_rate_code, ' . $this->db->dbprefix('categories') . '.name as category_name, ' . $this->db->dbprefix('subcategories') . '.code as subcategory_code, ' . $this->db->dbprefix('subcategories') . '.name as subcategory_name, '.$this->db->dbprefix('units') . '.name as p_unit' )
			->join('tax_rates', 'tax_rates.id=products.tax_rate', 'left')
			->join('categories', 'categories.id=products.category_id', 'left')
			->join('subcategories', 'subcategories.id=products.subcategory_id', 'left')
			->join('units', 'products.unit=units.id', 'left')
			->join('warehouses', 'warehouses.id=products.warehouse', 'left')
			->group_by("products.id")->order_by('products.id desc');
			$q = $this->db->get_where('products', array('products.id' => $id), 1);
	if ($q->num_rows() > 0) {
		return $q->row();
	}
	return FALSE;
    }

    public function getProductByCategoryID($id)
    {

        $q = $this->db->get_where('products', array('category_id' => $id), 1);
        if ($q->num_rows() > 0) {
            return true;
        }

        return FALSE;
    }

    public function getAllWarehousesWithPQ($product_id)
    {
		
        $this->db->select('' . $this->db->dbprefix('warehouses') . '.*, ' . $this->db->dbprefix('warehouses_products') . '.quantity, ' . $this->db->dbprefix('warehouses_products') . '.rack')
            ->join('warehouses_products', 'warehouses_products.warehouse_id=warehouses.id', 'left')
            ->where('warehouses_products.product_id', $product_id)
            ->group_by('warehouses.id');
		
		if (!$this->Owner && !$this->Admin && $this->session->userdata('warehouse_id')) {
			$this->db->where_in('warehouses.id', explode(',',$this->session->userdata('warehouse_id')));
		}
		
        $q = $this->db->get('warehouses');
        if ($q->num_rows() > 0) {
            foreach (($q->result()) as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return FALSE;
    }

    public function getProductPhotos($id)
    {
        $q = $this->db->get_where("product_photos", array('product_id' => $id));
        if ($q->num_rows() > 0) {
            foreach (($q->result()) as $row) {
                $data[] = $row;
            }

            return $data;
        }
    }
	public function getOptionId($product_id,$name)
    {

        $q = $this->db->get_where('product_variants', array('product_id' => $product_id, 'name'=>$name), 1);
        if ($q->num_rows() > 0) {
            return $q->row();
        }

        return FALSE;
    }
	
	public function getProductVariantByOptionID($option_id)
    {
        $q = $this->db->get_where('product_variants', array('id' => $option_id), 1);
        if ($q->num_rows() > 0) {
            return $q->row();
        }

        return FALSE;
    }
	
    public function getProductByCode($code)
    {

        $q = $this->db->get_where('products', array('code' => $code), 1);
        if ($q->num_rows() > 0) {
            return $q->row();
        }

        return FALSE;
    }

    public function addProduct($data, $items, $warehouse_qty, $product_attributes, $photos, $related_products=NULL)
    {
		//$this->erp->print_arrays($data, $items, $warehouse_qty, $product_attributes, $photos);
        if ($this->db->insert('products', $data)) {
            $product_id = $this->db->insert_id();

            if ($items) {
                foreach ($items as $item) {
                    $item['product_id'] = $product_id;
                    $this->db->insert('combo_items', $item);
                }
            }

            //if ($data['type'] == 'combo' || $data['type'] == 'service') {
                $warehouses = $this->site->getAllWarehouses();
                foreach ($warehouses as $warehouse) {
                    $this->db->insert('warehouses_products', array('product_id' => $product_id, 'warehouse_id' => $warehouse->id, 'quantity' => 0));
                }
            //}

            $tax_rate = $this->site->getTaxRateByID($data['tax_rate']);

            if ($warehouse_qty && !empty($warehouse_qty)) {
                foreach ($warehouse_qty as $wh_qty) {
                    if (isset($wh_qty['quantity']) && ! empty($wh_qty['quantity'])) {
                        $this->db->insert('warehouses_products', array('product_id' => $product_id, 'warehouse_id' => $wh_qty['warehouse_id'], 'quantity' => $wh_qty['quantity'], 'rack' => $wh_qty['rack']));

                        if (!$product_attributes) {
                            $tax_rate_id = $tax_rate ? $tax_rate->id : NULL;
                            $tax = $tax_rate ? (($tax_rate->type == 1) ? $tax_rate->rate . "%" : $tax_rate->rate) : NULL;
                            $unit_cost = $data['cost'];
                            if ($tax_rate) {
                                if ($tax_rate->type == 1 && $tax_rate->rate != 0) {
                                    if ($data['tax_method'] == '0') {
                                        $pr_tax_val = ($data['cost'] * $tax_rate->rate) / (100 + $tax_rate->rate);
                                        $net_item_cost = $data['cost'] - $pr_tax_val;
                                        $item_tax = $pr_tax_val * $wh_qty['quantity'];
                                    } else {
                                        $net_item_cost = $data['cost'];
                                        $pr_tax_val = ($data['cost'] * $tax_rate->rate) / 100;
                                        $unit_cost = $data['cost'] + $pr_tax_val;
                                        $item_tax = $pr_tax_val * $wh_qty['quantity'];
                                    }
                                } else {
                                    $net_item_cost = $data['cost'];
                                    $item_tax = $tax_rate->rate;
                                }
                            } else {
                                $net_item_cost = $data['cost'];
                                $item_tax = 0;
                            }

                            $subtotal = (($net_item_cost * $wh_qty['quantity']) + $item_tax);

                            $item = array(
                                'product_id' => $product_id,
                                'product_code' => $data['code'],
                                'product_name' => $data['name'],
                                'net_unit_cost' => $net_item_cost,
                                'unit_cost' => $unit_cost,
                                'quantity' => $wh_qty['quantity'],
                                'quantity_balance' => $wh_qty['quantity'],
                                'item_tax' => $item_tax,
                                'tax_rate_id' => $tax_rate_id,
                                'tax' => $tax,
                                'subtotal' => $subtotal,
                                'warehouse_id' => $wh_qty['warehouse_id'],
                                'date' => date('Y-m-d'),
                                'status' => 'received',
                            );
                            $this->db->insert('purchase_items', $item);
                            $this->site->syncProductQty($product_id, $wh_qty['warehouse_id']);
                        }
                    }
                }
            }

            if ($product_attributes) {
                foreach ($product_attributes as $pr_attr) {
                    $pr_attr_details = $this->getPrductVariantByPIDandName($product_id, $pr_attr['name']);

                    $pr_attr['product_id'] = $product_id;
                    $variant_warehouse_id = $pr_attr['warehouse_id'];
                    unset($pr_attr['warehouse_id']);
                    if ($pr_attr_details) {
                        $option_id = $pr_attr_details->id;
                    } else {
                        $this->db->insert('product_variants', $pr_attr);
                        $option_id = $this->db->insert_id();
                    }
                    if ($pr_attr['quantity'] != 0) {
                        $this->db->insert('warehouses_products_variants', array('option_id' => $option_id, 'product_id' => $product_id, 'warehouse_id' => $variant_warehouse_id, 'quantity' => $pr_attr['quantity']));

                        $tax_rate_id = $tax_rate ? $tax_rate->id : NULL;
                        $tax = $tax_rate ? (($tax_rate->type == 1) ? $tax_rate->rate . "%" : $tax_rate->rate) : NULL;
                        $unit_cost = $data['cost'];
                        if ($tax_rate) {
                            if ($tax_rate->type == 1 && $tax_rate->rate != 0) {
                                if ($data['tax_method'] == '0') {
                                    $pr_tax_val = ($data['cost'] * $tax_rate->rate) / (100 + $tax_rate->rate);
                                    $net_item_cost = $data['cost'] - $pr_tax_val;
                                    $item_tax = $pr_tax_val * $pr_attr['quantity'];
                                } else {
                                    $net_item_cost = $data['cost'];
                                    $pr_tax_val = ($data['cost'] * $tax_rate->rate) / 100;
                                    $unit_cost = $data['cost'] + $pr_tax_val;
                                    $item_tax = $pr_tax_val * $pr_attr['quantity'];
                                }
                            } else {
                                $net_item_cost = $data['cost'];
                                $item_tax = $tax_rate->rate;
                            }
                        } else {
                            $net_item_cost = $data['cost'];
                            $item_tax = 0;
                        }

                        $subtotal = (($net_item_cost * $pr_attr['quantity']) + $item_tax);
                        $item = array(
                            'product_id' => $product_id,
                            'product_code' => $data['code'],
                            'product_name' => $data['name'],
                            'net_unit_cost' => $net_item_cost,
                            'unit_cost' => $unit_cost,
                            'quantity' => $pr_attr['quantity'],
                            'option_id' => $option_id,
                            'quantity_balance' => $pr_attr['quantity'],
                            'item_tax' => $item_tax,
                            'tax_rate_id' => $tax_rate_id,
                            'tax' => $tax,
                            'subtotal' => $subtotal,
                            'warehouse_id' => $variant_warehouse_id,
                            'date' => date('Y-m-d'),
                            'status' => 'received',
                        );
                        $this->db->insert('purchase_items', $item);

                    }

                    $this->site->syncVariantQty($option_id, $variant_warehouse_id);
                }
            }

            if ($photos) {
                foreach ($photos as $photo) {
                    $this->db->insert('product_photos', array('product_id' => $product_id, 'photo' => $photo));
                }
            }
			
			if ($related_products) {
				foreach ($related_products as $related_product) {
                    $this->db->insert('related_products', $related_product);
                }
			}

            return $product_id;
        }

        return false;

    }
	
	

    public function getPrductVariantByPIDandName($product_id, $name)
    {
        $q = $this->db->get_where('product_variants', array('product_id' => $product_id, 'name' => $name), 1);
        if ($q->num_rows() > 0) {
            return $q->row();
        }

        return FALSE;
    }

    public function addAjaxProduct($data)
    {

        if ($this->db->insert('products', $data)) {
            $product_id = $this->db->insert_id();
            return $this->getProductByID($product_id);
        }

        return false;

    }

    public function add_products($products = array())
    {
		
        if (!empty($products)) {
            foreach ($products as $product) { 
                $variants = explode('|', $product['variants']);
				
				
                unset($product['variants']);
                if ($this->db->insert('products', $product)) {
                   $product_id = $this->db->insert_id();
                    foreach ($variants as $variant) {
						$va_seps = explode('=', $variant);
						$price   = explode('#',$variant);
						
						$va_name = $va_seps[0];
						$va_qty_unit = $va_seps[1] ? $va_seps[1] : 1;
						
                        if ($va_name && trim($va_name) != '') {
                            $vat = array('product_id' => $product_id, 'name' => trim($va_name), 'qty_unit' => $va_qty_unit,'price'=>$price[1]);
                            $this->db->insert('product_variants', $vat);
                        }
                    }
                }
            }
            return true;
        }
        return false;
    }

    public function getProductNames($term, $warehouse_id, $limit = 5)
    {
		$this->db->select('products.*,  COALESCE(erp_warehouses_products.quantity, 0) as qoh');
        $this->db->where("type = 'standard' AND (name LIKE '%" . $term . "%' OR code LIKE '%" . $term . "%' OR  concat(name, ' (', code, ')') LIKE '%" . $term . "%')");
		$this->db->where("warehouses_products.warehouse_id", $warehouse_id);
        $this->db->limit($limit);
		$this->db->join('warehouses_products', 'warehouses_products.product_id = products.id', 'left');
        $q = $this->db->get('products');
        if ($q->num_rows() > 0) {
            foreach (($q->result()) as $row) {
                $data[] = $row;
            }
            return $data;
        }
    }
	
	public function getUsingStockProducts($term, $warehouse_id, $limit = 5)
    {
        $this->db->where("type = 'standard' AND (erp_products.name LIKE '%" . $term . "%' OR erp_products.code LIKE '%" . $term . "%' OR  concat(erp_products.name, ' (', erp_products.code, ')') LIKE '%" . $term . "%')");
		$this->db->where("warehouses_products.warehouse_id", $warehouse_id);
        $this->db->limit($limit);
		$this->db->select('products.*, warehouses_products.quantity as qoh, units.name as unit_name');
		$this->db->join('warehouses_products', 'warehouses_products.product_id = products.id', 'left');
		$this->db->join('units', 'units.id = products.unit', 'left');
        $q = $this->db->get('products');
        if ($q->num_rows() > 0) {
            foreach (($q->result()) as $row) {
                $data[] = $row;
            }
            return $data;
        }
    }
	
	public function getUnitAndVaraintByProductId($id)
	{
		$variant = $this->db->select("products.*, 
									'1' as measure_qty, 
									product_variants.name as unit_variant")
									->from("products")
									->where("products.id",$id)																		
									->join("product_variants","products.id=product_variants.product_id","left")
									->get();					
		$unit_of_measure = $this->getUnitOfMeasureByProductId($id);
		if($variant->num_rows() > 0 && $variant->row()->unit_variant != null){
			return $variant->result();
		}else{
			return $unit_of_measure;
		}			
	}
	public function getProductNumber($term, $warehouse_id, $limit = 5)
    {
		if(preg_match('/\s/', $term))
		{
			$name = explode(" ", $term);
			$first = $name[0];
			$this->db->select('products.*,  COALESCE(erp_warehouses_products.quantity, 0) as qoh')->group_by('products.id');
			$this->db->join('warehouses_products', 'warehouses_products.product_id = products.id', 'left');
			$this->db->where(array('code'=> $first, 'warehouses_products.warehouse_id'=>$warehouse_id));
			$this->db->limit($limit);
			$q = $this->db->get('products');
			if ($q->num_rows() > 0) {
				foreach (($q->result()) as $row) {
					$data[] = $row;
				}
				return $data;
			}
		}else
		{		
			$this->db->select('products.*,  COALESCE(erp_warehouses_products.quantity, 0) as qoh')->group_by('products.id');
			$this->db->where("type = 'standard' AND (code LIKE '%" . $term . "%')");
			$this->db->where("warehouses_products.warehouse_id", $warehouse_id);
			$this->db->limit($limit);
			$this->db->join('warehouses_products', 'warehouses_products.product_id = products.id', 'left');
			$q = $this->db->get('products');
			if ($q->num_rows() > 0) {
				foreach (($q->result()) as $row) {
					$data[] = $row;
				}
				return $data;
			}
		}
	}
	
	public function getProductCode($term)
    {
        $this->db->select('code');
		$q = $this->db->get_where('products', array('code' => $term), 1);
        if ($q->num_rows() > 0) {
            return $q->row();
        }
    }

    public function updateProduct($id, $data, $items, $warehouse_qty, $product_attributes, $photos, $update_variants, $related_products=NULL)
    {
		//$this->erp->print_arrays($id, $data, $items, $warehouse_qty, $product_attributes, $photos, $update_variants);
        if ($this->db->update('products', $data, array('id' => $id))) {

            if ($items) {
                $this->db->delete('combo_items', array('product_id' => $id));
                foreach ($items as $item) {
                    $item['product_id'] = $id;
                    $this->db->insert('combo_items', $item);
                }
            }

            $tax_rate = $this->site->getTaxRateByID($data['tax_rate']);

            if ($warehouse_qty && !empty($warehouse_qty)) {
                foreach ($warehouse_qty as $wh_qty) {
                    $this->db->update('warehouses_products', array('rack' => $wh_qty['rack']), array('product_id' => $id, 'warehouse_id' => $wh_qty['warehouse_id']));
                }
            }

            if ($update_variants) {
                $this->db->update_batch('product_variants', $update_variants, 'id');
            }

            if ($photos) {
                foreach ($photos as $photo) {
                    $this->db->insert('product_photos', array('product_id' => $id, 'photo' => $photo));
                }
            }

            if ($product_attributes) {
                foreach ($product_attributes as $pr_attr) {

                    $pr_attr['product_id'] = $id;
                    $variant_warehouse_id = $pr_attr['warehouse_id'];
                    unset($pr_attr['warehouse_id']);
                    $this->db->insert('product_variants', $pr_attr);
                    $option_id = $this->db->insert_id();

                    if ($pr_attr['quantity'] != 0) {
                        $this->db->insert('warehouses_products_variants', array('option_id' => $option_id, 'product_id' => $id, 'warehouse_id' => $variant_warehouse_id, 'quantity' => $pr_attr['quantity']));

                        $tax_rate_id = $tax_rate ? $tax_rate->id : NULL;
                        $tax = $tax_rate ? (($tax_rate->type == 1) ? $tax_rate->rate . "%" : $tax_rate->rate) : NULL;
                        $unit_cost = $data['cost'];
                        if ($tax_rate) {
                            if ($tax_rate->type == 1 && $tax_rate->rate != 0) {
                                if ($data['tax_method'] == '0') {
                                    $pr_tax_val = ($data['cost'] * $tax_rate->rate) / (100 + $tax_rate->rate);
                                    $net_item_cost = $data['cost'] - $pr_tax_val;
                                    $item_tax = $pr_tax_val * $pr_attr['quantity'];
                                } else {
                                    $net_item_cost = $data['cost'];
                                    $pr_tax_val = ($data['cost'] * $tax_rate->rate) / 100;
                                    $unit_cost = $data['cost'] + $pr_tax_val;
                                    $item_tax = $pr_tax_val * $pr_attr['quantity'];
                                }
                            } else {
                                $net_item_cost = $data['cost'];
                                $item_tax = $tax_rate->rate;
                            }
                        } else {
                            $net_item_cost = $data['cost'];
                            $item_tax = 0;
                        }

                        $subtotal = (($net_item_cost * $pr_attr['quantity']) + $item_tax);
                        $item = array(
                            'product_id' => $id,
                            'product_code' => $data['code'],
                            'product_name' => $data['name'],
                            'net_unit_cost' => $net_item_cost,
                            'unit_cost' => $unit_cost,
                            'quantity' => $pr_attr['quantity'],
                            'option_id' => $option_id,
                            'quantity_balance' => $pr_attr['quantity'],
                            'item_tax' => $item_tax,
                            'tax_rate_id' => $tax_rate_id,
                            'tax' => $tax,
                            'subtotal' => $subtotal,
                            'warehouse_id' => $variant_warehouse_id,
                            'date' => date('Y-m-d'),
                            'status' => 'received',
                        );
                        $this->db->insert('purchase_items', $item);

                    }
                }
            }
			
			if ($related_products) {
				foreach ($related_products as $related_product) {
                    $this->db->insert('related_products', $related_product);
                }
			}

            $this->site->syncQuantity(NULL, NULL, NULL, $id);
            return true;
        } else {
            return false;
        }
    }

    public function updateProductOptionQuantity($option_id, $warehouse_id, $quantity, $product_id)
    {
        if ($option = $this->getProductWarehouseOptionQty($option_id, $warehouse_id)) {
            if ($this->db->update('warehouses_products_variants', array('quantity' => $quantity), array('option_id' => $option_id, 'warehouse_id' => $warehouse_id))) {
                $this->site->syncVariantQty($option_id, $warehouse_id);
                return TRUE;
            }
        } else {
            if ($this->db->insert('warehouses_products_variants', array('option_id' => $option_id, 'product_id' => $product_id, 'warehouse_id' => $warehouse_id, 'quantity' => $quantity))) {
                $this->site->syncVariantQty($option_id, $warehouse_id);
                return TRUE;
            }
        }
        return FALSE;
    }

    public function getPurchasedItemDetails($product_id, $warehouse_id, $option_id = NULL)
    {
        $q = $this->db->get_where('purchase_items', array('product_id' => $product_id, 'option_id' => $option_id, 'warehouse_id' => $warehouse_id), 1);
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return FALSE;
    }

    public function getPurchasedItemDetailsWithOption($product_id, $warehouse_id, $option_id)
    {
        $q = $this->db->get_where('purchase_items', array('product_id' => $product_id, 'purchase_id' => NULL, 'transfer_id' => NULL, 'warehouse_id' => $warehouse_id, 'option_id' => $option_id), 1);
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return FALSE;
    }

    public function updatePrice($data = array())
    {

        if ($this->db->update_batch('products', $data, 'code')) {
            return true;
        } else {
            return false;
        }
    }
	
	public function updateQuantityExcel($data = array())
    {

        $rows = array();
		if($data){
		  foreach ($data as $row) {
			if(!$row['cost']){
			  //unset($row['cost']);
			}
			$rows[] = $row;
		  }
		}
		if ($this->db->update_batch('products', $data, 'code')) {
			return true;
		} else {
			return false;
		}
    }
	public function updateQuantityExcelWarehouse($data = array())
    {
		foreach($data as $value){
			$que_data=array('quantity'=>$value['quantity']);
			$where = array(
			'product_id'=>$value['product_id'],
			'warehouse_id'=>$value['warehouse_id']
			);
			$this->db->update('warehouses_products',$que_data,$where);
		}
        /*if ($this->db->update_batch('warehouses_products', $data, 'product_id')) {
            return true;
        } else {
            return false;
        }*/
		return true;
    }
	public function updateQuantityExcelVar($data = array())
    {
		foreach($data as $value){
			$que_data=array('quantity'=>$value['quantity'],'option_id'=>$value['option_id']);
			$where = array(
			'product_id'=>$value['product_id'],
			'warehouse_id'=>$value['warehouse_id']
			);
			$this->db->update('warehouses_products_variants',$que_data,$where);
		}
		return true;
        /*if ($this->db->update_batch('warehouses_products_variants', $data, 'product_id')) {
            return true;
        } else {
            return false;
        }*/
    }
	public function updateQuantityExcelPurchase($data = array())
    {
		foreach($data as $value){

      /*
			$where = array(
				'product_id'=>$value['product_id'],
				'warehouse_id'=>$value['warehouse_id'],
				'option_id'=>$value['option_id']
			);
			$que_data=array('quantity_balance'=>$value['quantity_balance']);

			$this->db->select('id');
			$this->db->from('purchase_items');
			$this->db->where($where);
			$this->db->order_by('id','DESC');
			$this->db->limit(1);
			$res=$this->db->get();


			if($res->num_rows()>0){
		//		$this->db->update('purchase_items',$que_data,array('id'=>$res->row()->id));
				//if we open code below it will got error when we update secord time;
				//$this->db->where($where);
			}else{
      */
			$this->db->select('*');
			$this->db->from('products');
			$this->db->where(array('id'=>$value['product_id']));
			$prod=$this->db->get();

			$pur_data = array(
				'product_id'=>$value['product_id'],
				'product_code'=>$prod->row()->code,
				'product_name'=>$prod->row()->name,
				'warehouse_id'=>$value['warehouse_id'],
				'option_id'=>$value['option_id'],
				'quantity'=>$value['quantity_balance'],
				'opening_stock'=>$value['opening_stock'],
				'quantity_balance'=>$value['quantity_balance'],
				'quantity_received'=>$value['quantity_balance'],
				'net_unit_cost' => $value['cost'],
				'unit_cost' => $value['cost'],
				'real_unit_cost' => $value['cost'],
				'subtotal' => $value['cost'] * $value['quantity_balance'],
				'status' => 'received',
				'date' => date('Y-m-d')
			);
			
			if(isset($value['transaction_type'])){
				$pur_data['transaction_type'] = $value['transaction_type'];
			}
			
			$this->db->insert('purchase_items',$pur_data);
			// }
			$this->site->syncQuantity(NULL, NULL, NULL, $value['product_id']);
		}
		return true;
    }
	
	public function insertGlTran($total_cost)
	{
		$v_tran_no = $this->db->select('(COALESCE (MAX(tran_no), 0) + 1) as tran')->from('gl_trans')->get()->row()->tran;
		$v_reference = $this->db->select('COUNT(*) as trans')->from('purchase_items')->where('option_id', 3)->get()->row()->trans;
		$tran = $this->getTrans('default_purchase');
		$dob = $this->getTrans('default_open_balance');
		$data = array(
			array(
				'tran_type'    => 'JOURNAL',
				'tran_no'      => $v_tran_no,
				'tran_date'    => date('Y-m-d h:i:s'),
				'sectionid'    => $tran->sectionid,
				'account_code' => $tran->accountcode,
				'narrative'    => $tran->accountname,
				'amount'       => $total_cost,
				'reference_no' => '000'.$v_reference,
				'description'  => 'Import Quantity',
				'biller_id'    => $this->Settings->default_biller,
				'created_by'   => $this->session->userdata('user_id')
			),
			array(
				'tran_type'    => 'JOURNAL',
				'tran_no'      => $v_tran_no,
				'tran_date'    => date('Y-m-d h:i:s'),
				'sectionid'    => $dob->sectionid,
				'account_code' => $dob->accountcode,
				'narrative'    => $dob->accountname,
				'amount'       => (-1) * $total_cost,
				'reference_no' => '000'.$v_reference,
				'description'  => 'Import Quantity',
				'biller_id'    => $this->Settings->default_biller,
				'created_by'   => $this->session->userdata('user_id')
			)
		);
		//$this->erp->print_arrays($data);
		$this->db->insert_batch('gl_trans',$data);
	}
	
	public function getTrans($type)
	{
		$this->db->select('erp_gl_sections.sectionid, erp_gl_charts.accountcode, erp_gl_charts.accountname')
				 ->from('erp_account_settings')
				 ->join('erp_gl_charts', 'erp_gl_charts.accountcode = erp_account_settings.'.$type , 'INNER')
				 ->join('erp_gl_sections', 'erp_gl_sections.sectionid = erp_gl_charts.sectionid' , 'INNER')
				 ->where('erp_gl_charts.accountcode = erp_account_settings.'.$type);
		$q = $this->db->get();
		if ($q->num_rows() > 0) {
            return $q->row();
        }

        return FALSE;
	}
	public function getProductfordelete($id){
		 $this->db->select('erp_products.id')
		          ->join('erp_sale_items', 'erp_sale_items.product_id=erp_products.id', 'left')
				  ->join('erp_purchase_items', 'erp_purchase_items.product_id=erp_products.id', 'left')
		          ->from('erp_products')
				  ->where('erp_sale_items.product_id = "'.$id.'" ')
				  ->or_where('erp_purchase_items.product_id ="'.$id.'"');
			$q=$this->db->get();
		if ($q->num_rows() > 0) {
            return $q->row();
        }

        return FALSE;
	}
    public function deleteProduct($id)
    {
        if ($this->db->delete('products', array('id' => $id)) && $this->db->delete('warehouses_products', array('product_id' => $id)) && $this->db->delete('warehouses_products_variants', array('product_id' => $id))) {
            return true;
        }
        return FALSE;
    }


    public function totalCategoryProducts($category_id)
    {
        $q = $this->db->get_where('products', array('category_id' => $category_id));

        return $q->num_rows();
    }

    public function getSubcategoryByID($id)
    {
        $q = $this->db->get_where('subcategories', array('id' => $id), 1);
        if ($q->num_rows() > 0) {
            return $q->row();
        }

        return FALSE;
    }

    public function getCategoryByCode($code)
    {
        $q = $this->db->get_where('categories', array('code' => $code), 1);
        if ($q->num_rows() > 0) {
            return $q->row();
        }

        return FALSE;
    }

    public function getSubcategoryByCode($code)
    {

        $q = $this->db->get_where('subcategories', array('code' => $code), 1);
        if ($q->num_rows() > 0) {
            return $q->row();
        }

        return FALSE;
    }

    public function getTaxRateByName($name)
    {
        $q = $this->db->get_where('tax_rates', array('name' => $name), 1);
        if ($q->num_rows() > 0) {
            return $q->row();
        }

        return FALSE;
    }

    public function getSubCategories()
    {
        $this->db->select('id as id, name as text');
        $q = $this->db->get("subcategories");
        if ($q->num_rows() > 0) {
            foreach (($q->result()) as $row) {
                $data[] = $row;
            }

            return $data;
        }

        return FALSE;
    }
	
	public function getCategoriesForBrandID($brand_id)
    {
        $this->db->select('id as id, name as text');
        $q = $this->db->get_where("categories", array('brand_id' => $brand_id));
        if ($q->num_rows() > 0) {
            foreach (($q->result()) as $row) {
                $data[] = $row;
            }

            return $data;
        }

        return FALSE;
    }

    public function getSubCategoriesForCategoryID($category_id)
    {
        $this->db->select('id as id, name as text');
        $q = $this->db->get_where("subcategories", array('category_id' => $category_id));
        if ($q->num_rows() > 0) {
            foreach (($q->result()) as $row) {
                $data[] = $row;
            }

            return $data;
        }

        return FALSE;
    }

    public function getSubCategoriesByCategoryID($category_id)
    {
        $q = $this->db->get_where("subcategories", array('category_id' => $category_id));
        if ($q->num_rows() > 0) {
            foreach (($q->result()) as $row) {
                $data[] = $row;
            }

            return $data;
        }

        return FALSE;
    }

    public function getAdjustmentByID($id)
    {
        $q = $this->db->get_where('adjustments', array('id' => $id), 1);
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return FALSE;
    }

    public function syncAdjustment($data = array())
    {
        if(! empty($data)) {
			$pr = $this->site->getProductByID($data['product_id']);
			$qty_balance = $data['type'] == 'subtraction' ? (0 - $data['quantity']) : $data['quantity'];
			if($data['option_id']){
				$option = $this->site->getProductVariantOptionIDPID($data['option_id'], $data['product_id']);
				$qty_balance = $qty_balance * $option->qty_unit;
			}
			
			$item = array(
				'product_id' 		=> $data['product_id'],
				'product_code' 		=> $pr->code,
				'product_name' 		=> $pr->name,
				'net_unit_cost' 	=> 0,
				'unit_cost' 		=> 0,
				'quantity' 			=> 0,
				'option_id' 		=> $data['option_id'],
				'quantity_balance' 	=> $qty_balance ,
				'item_tax' 			=> 0,
				'tax_rate_id' 		=> 0,
				'tax' 				=> '',
				'subtotal' 			=> 0,
				'warehouse_id' 		=> $data['warehouse_id'],
				'date' 				=> date('Y-m-d'),
				'status' 			=> 'received',
			);
			$this->db->insert('purchase_items', $item);

            $this->site->syncProductQty($data['product_id'], $data['warehouse_id']);
            if ($data['option_id']) {
                $this->site->syncVariantQty($data['option_id'], $data['warehouse_id'], $data['product_id']);
            }
        }
    }

    public function reverseAdjustment($id)
    {
        if ($adjustment = $this->getAdjustmentByID($id)) {

            if ($purchase_item = $this->getPurchasedItemDetails($adjustment->product_id, $adjustment->warehouse_id, $adjustment->option_id)) {
                $quantity_balance = $adjustment->type == 'subtraction' ? $purchase_item->quantity_balance + $adjustment->quantity : $purchase_item->quantity_balance - $adjustment->quantity;
                $this->db->update('purchase_items', array('quantity_balance' => $quantity_balance), array('id' => $purchase_item->id));
            }

            $this->site->syncProductQty($adjustment->product_id, $adjustment->warehouse_id);
            if ($adjustment->option_id) {
                $this->site->syncVariantQty($adjustment->option_id, $adjustment->warehouse_id, $adjustment->product_id);
            }
        }
    }
	public function getAdjustment($id){
        $this->db
            ->select('adjustments.id as id,
                adjustments.date,
                adjustments.reference_no,
                warehouses.`name` as wh_name,
                users.last_name as created_by,
                adjustments.note,
                adjustments.attachment', FALSE)
            ->join('warehouses', 'warehouses.id = adjustments.warehouse_id', 'left')
            ->join('users', 'users.id = adjustments.created_by', 'left')
            ->where('adjustments.id', $id)
            ->group_by('adjustments.id');
        $q = $this->db->get('adjustments');
        if ($q->num_rows() > 0) {
            return $q->result();
        }
        return false;
    }
	
	public function getAdjustmentList($id){
        $this->db
            ->select('adjustment_items.*,products.code,products.name,product_variants.name as variants')
			->join('products', 'products.id = adjustment_items.product_id','left' )
			->join('product_variants', 'product_variants.product_id = products.id 
				AND product_variants.id = adjustment_items.option_id','INNER' )  
			->where('adjustment_items.adjust_id', $id)
            ->group_by('adjustment_items.id');
        $query = $this->db->get('adjustment_items');
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
    }
	
	
	
	
	public function addAdjustment($data, $dataPurchase = NULL)
    {
		$p 			= $this->getProductByID($data['product_id']);
		$cost 		= $p->cost;
		$total_cost = 0;
		if($data['option_id']){
			$option = $this->getProductVariantByOptionID($data['option_id']);
			$total_cost = $cost * ($data['quantity'] * $option->qty_unit);
		}else{
			$total_cost = $cost * $data['quantity'];
		}
		
		$data['cost'] 		= $cost;
		$data['total_cost'] = $total_cost;
        if ($this->db->insert('adjustments', $data)) {
			$insert_id = $this->db->insert_id();
			$dataPurchase['transaction_id'] = $insert_id;
			$this->db->insert('purchase_items', $dataPurchase);			
			
            $this->site->syncQuantitys(null, null, null, $data['product_id']);
            return true;
        }
        return false;
    }
	
	public function addMultiAdjustment($data, $dataPurchase = NULL)
    {
		
        if ($this->db->insert('adjustments', $data)) {
			$adjustment_id = $this->db->insert_id();
			$quantity_balance = 0;
			foreach($dataPurchase as $products){
				$products['adjust_id'] 	= $adjustment_id;
				$quantity_balance = $products['quantity_balance'];
				unset($products['quantity_balance']);
                $this->db->insert('adjustment_items', $products);
				$adjust_item_id = $this->db->insert_id();
				
				unset($products['adjust_id']);
				unset($products['cost']);
				unset($products['total_cost']);
				unset($products['type']);
				unset($products['biller_id']);
				$products['date'] = date('Y-m-d');
				$products['quantity_balance'] 	= $quantity_balance;
				$products['transaction_id'] 	= $adjust_item_id;
				$products['transaction_type'] 	= 'ADJUSTMENT';
				$products['status'] 			= 'received';

				$this->db->insert('purchase_items', $products);	
				$product_cost = $this->site->getProductByID($products['product_id']);
				$this->db->update("inventory_valuation_details",array('cost'=>$product_cost->cost,'avg_cost'=>$product_cost->cost,'date'=>date("Y-m-d H:i:s"),'reference_no'=>$data['reference_no']),array('field_id'=>$adjust_item_id));
			}
			
			if ($this->site->getReference('qa',$data['biller_id']) == $data['reference_no']) {
                $this->site->updateReference('qa',$data['biller_id']);
            }
			foreach($dataPurchase as $products){
				$this->site->syncQuantitys(null, null, null, $products['product_id']);
			}			
			return true;
        }
        return false;
    }
	
    public function updateAdjustment($id, $data)
    {
		$p = $this->getProductByID($data['product_id']);
		$cost = $p->cost;
		$total_cost = 0;
		if($data['option_id']){
			$option = $this->getProductVariantByOptionID($data['option_id']);
			$total_cost = $cost * ($data['quantity'] * $option->qty_unit);
		}else{
			$total_cost = $cost * $data['quantity'];
		}
		
		$data['cost'] = $cost;
		$data['total_cost'] = $total_cost;
        $this->reverseAdjustment($id);
        if ($this->db->update('adjustments', $data, array('id' => $id))) {
            $this->syncAdjustment($data);
            return true;
        }
        return false;
    }

    public function deleteAdjustment($id)
    {
        $this->reverseAdjustment($id);
        if ( $this->db->delete('adjustments', array('id' => $id))) {
            return true;
        }
        return false;
    }

    public function getProductQuantity($product_id, $warehouse)
    {
        $q = $this->db->get_where('warehouses_products', array('product_id' => $product_id, 'warehouse_id' => $warehouse), 1);
        if ($q->num_rows() > 0) {
            return $q->row_array(); //$q->row();
        }
        return FALSE;
    }

    public function addQuantity($product_id, $warehouse_id, $quantity, $rack = NULL)
    {

        if ($this->getProductQuantity($product_id, $warehouse_id)) {
            if ($this->updateQuantity($product_id, $warehouse_id, $quantity, $rack)) {
                return TRUE;
            }
        } else {
            if ($this->insertQuantity($product_id, $warehouse_id, $quantity, $rack)) {
                return TRUE;
            }
        }

        return FALSE;
    }

    public function insertQuantity($product_id, $warehouse_id, $quantity, $rack = NULL)
    {
        if ($this->db->insert('warehouses_products', array('product_id' => $product_id, 'warehouse_id' => $warehouse_id, 'quantity' => $quantity, 'rack' => $rack))) {
            $this->site->syncProductQty($product_id, $warehouse_id);
            return true;
        }
        return false;
    }

    public function updateQuantity($product_id, $warehouse_id, $quantity, $rack = NULL)
    {
        $data = $rack ? array('quantity' => $quantity, 'rack' => $rack) : $data = array('quantity' => $quantity);
        if ($this->db->update('warehouses_products', $data, array('product_id' => $product_id, 'warehouse_id' => $warehouse_id))) {
            $this->site->syncProductQty($product_id, $warehouse_id);
            return true;
        }
        return false;
    }

    public function products_count($category_id, $subcategory_id = NULL)
    {
        if ($category_id) {
            $this->db->where('category_id', $category_id);
        }
        if ($subcategory_id) {
            $this->db->where('subcategory_id', $subcategory_id);
        }
        $this->db->from('products');
        return $this->db->count_all_results();
    }

    public function fetch_products($category_id, $limit, $start, $subcategory_id = NULL)
    {

        $this->db->limit($limit, $start);
        if ($category_id) {
            $this->db->where('category_id', $category_id);
        }
        if ($subcategory_id) {
            $this->db->where('subcategory_id', $subcategory_id);
        }
        $this->db->order_by("id", "asc");
        $query = $this->db->get("products");

        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
    }

    public function getProductWarehouseOptionQty($option_id, $warehouse_id)
    {
        $q = $this->db->get_where('warehouses_products_variants', array('option_id' => $option_id, 'warehouse_id' => $warehouse_id), 1);
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return FALSE;
    }
	
    public function syncVariantQty($option_id)
    {
        $wh_pr_vars = $this->getProductWarehouseOptions($option_id);
        $qty = 0;
        foreach ($wh_pr_vars as $row) {
            $qty += $row->quantity;
        }
        if ($this->db->update('product_variants', array('quantity' => $qty), array('id' => $option_id))) {
            return TRUE;
        }
        return FALSE;
    }

    public function getProductWarehouseOptions($option_id)
    {
        $q = $this->db->get_where('warehouses_products_variants', array('option_id' => $option_id));
        if ($q->num_rows() > 0) {
            foreach (($q->result()) as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return FALSE;
    }

    public function setRack($data)
    {
        if ($this->db->update('warehouses_products', array('rack' => $data['rack']), array('product_id' => $data['product_id'], 'warehouse_id' => $data['warehouse_id']))) {
            return TRUE;
        }
        return FALSE;
    }

    public function getSoldQty($id)
    {
        $this->db->select("date_format(" . $this->db->dbprefix('sales') . ".date, '%Y-%M') month, SUM( " . $this->db->dbprefix('sale_items') . ".quantity ) as sold, SUM( " . $this->db->dbprefix('sale_items') . ".subtotal ) as amount")
            ->from('sales')
            ->join('sale_items', 'sales.id=sale_items.sale_id', 'left')
            ->group_by("date_format(" . $this->db->dbprefix('sales') . ".date, '%Y-%m')")
            ->where($this->db->dbprefix('sale_items') . '.product_id', $id)
            //->where('DATE(NOW()) - INTERVAL 1 MONTH')
            ->where('DATE_ADD(curdate(), INTERVAL 1 MONTH)')
            ->order_by("date_format(" . $this->db->dbprefix('sales') . ".date, '%Y-%m') desc")->limit(3);
        $q = $this->db->get();
        if ($q->num_rows() > 0) {
            foreach (($q->result()) as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return FALSE;
    }

    public function getPurchasedQty($id)
    {
        $this->db->select("date_format(" . $this->db->dbprefix('purchases') . ".date, '%Y-%M') month, SUM( " . $this->db->dbprefix('purchase_items') . ".quantity ) as purchased, SUM( " . $this->db->dbprefix('purchase_items') . ".subtotal ) as amount")
            ->from('purchases')
            ->join('purchase_items', 'purchases.id=purchase_items.purchase_id', 'left')
            ->group_by("date_format(" . $this->db->dbprefix('purchases') . ".date, '%Y-%m')")
            ->where($this->db->dbprefix('purchase_items') . '.product_id', $id)
            //->where('DATE(NOW()) - INTERVAL 1 MONTH')
            ->where('DATE_ADD(curdate(), INTERVAL 1 MONTH)')
            ->order_by("date_format(" . $this->db->dbprefix('purchases') . ".date, '%Y-%m') desc")->limit(3);
        $q = $this->db->get();
        if ($q->num_rows() > 0) {
            foreach (($q->result()) as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return FALSE;
    }

    public function getAllVariants()
    {
        $q = $this->db->get('variants');
        if ($q->num_rows() > 0) {
            foreach (($q->result()) as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return FALSE;
    }
	
	/* ------ Project ----- */
	public function getProjects($id = null){
		$q = $this->db->get('variants');
        if ($q->num_rows() > 0) {
            foreach (($q->result()) as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return FALSE;
	}
	
	/* ------ Print Barcode Label ------ */
    /* Error
	public function getProductsForPrinting($term){
		$this->db->where('code', $term);
		$query = $this->db->get('products');
		
		if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
		
	}
    */
    
    public function getProductsForPrinting($term, $limit = 5)
    {
        $this->db->where("(name LIKE '%" . $term . "%' OR code LIKE '%" . $term . "%' OR  concat(name, ' (', code, ')') LIKE '%" . $term . "%')");
        $this->db->limit($limit);
        $q = $this->db->get('products');
        if ($q->num_rows() > 0) {
            foreach (($q->result()) as $row) {
                $data[] = $row;
            }
            return $data;
        }
    }
	
	public function getConvertItemsById($convert_id){
		$this->db->select('convert_items.product_id, convert_items.convert_id, convert_items.quantity AS c_quantity , (erp_products.cost * erp_convert_items.quantity) AS tcost, convert_items.status, products.cost AS p_cost, (erp_products.price * erp_convert_items.quantity) as tprice, convert_items.option_id');
		$this->db->join('products', 'products.id = convert_items.product_id', 'INNER');
		$this->db->where('convert_items.convert_id', $convert_id);
		$query = $this->db->get('convert_items');
		
		if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
	}
	
	public function getConvertItemsByIDPID($convert_id){
		$this->db->where('convert_id', $convert_id);
		$query = $this->db->get('convert_items');
		if ($query->num_rows() > 0) {
            return $query->result();
        }
        return false;
	}
	
	public function getConvertItemsAdd($convert_id){
		$this->db->select('convert_items.product_id, convert_items.convert_id, convert_items.quantity AS c_quantity , (erp_products.cost * erp_convert_items.quantity) AS tcost, convert_items.status, (erp_products.price * erp_convert_items.quantity) as tprice, product_variants.qty_unit, convert_items.option_id');
		$this->db->join('products', 'products.id = convert_items.product_id', 'INNER');
		$this->db->join('product_variants', 'product_variants.id = convert_items.option_id', 'left');
		$this->db->where('convert_items.convert_id', $convert_id);
		$this->db->where('convert_items.status', 'add');
		$query = $this->db->get('convert_items');
		
		if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
	}
	
	public function getConvertItemsDeduct($convert_id){
		$this->db->select('SUM(erp_products.cost * erp_convert_items.quantity) AS tcost, convert_items.status');
		$this->db->join('products', 'products.id = convert_items.product_id', 'INNER');
		$this->db->where('convert_items.convert_id', $convert_id);
		$this->db->where('convert_items.status', 'deduct');
		$query = $this->db->get('convert_items');
		
		if ($query->num_rows() > 0) {
            return $query->row();
        }
        return false;
	}
	
	public function getAllBoms(){
		$q = $this->db->get('bom');
        if ($q->num_rows() > 0) {
            return $q->result();
        }
        return FALSE;
	}
	
	public function getAllBom_id($id, $ware_id){
		$this->db->select('bom.*, bom_items.*, (SELECT COALESCE(quantity , 0) as qoh FROM erp_warehouses_products WHERE warehouse_id = '.$ware_id.' AND erp_warehouses_products.product_id = erp_bom_items.product_id) as qoh')
				 ->join('bom_items', 'bom.id = bom_items.bom_id')
				 ->join('products', 'bom_items.product_id = products.id')
				 ->where(array('bom.id'=>$id));
		$q = $this->db->get('bom');
        if ($q->num_rows() > 0) {
            return $q->result();
        }
        return FALSE;
	}

	public function getReference(){
		$this->db->select('reference_no')
				 ->order_by('date', 'desc')
				 ->limit(1);
		$q = $this->db->get('convert');
        if ($q->num_rows() > 0) {
			foreach ($q->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return FALSE;
	}
	
	public function getAllCurrencies()
    {
        $q = $this->db->get('currencies');
        if ($q->num_rows() > 0) {
            foreach (($q->result()) as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return FALSE;
    }
	public function getUserWarehouses()
    {
		$query = $this->db->query('
			SELECT
				*
			FROM
				erp_warehouses
			WHERE
				id IN ('.$this->session->userdata('warehouse_id').')
			GROUP BY id
		');
		if ($query->num_rows() > 0) {
			foreach($query->result() as $row){
				$data[] = $row;
			}
			return $data;
		}
		return false;
    }
	// using stock //
	public function getWarehouseQty($product_id, $warehouse_id){
        $this->db->select('SUM(quantity) as quantity')
                 ->from('warehouses_products')
                 ->where(array('product_id'=>$product_id, 'warehouse_id'=>$warehouse_id));
        $q = $this->db->get();
        if($q->num_rows() > 0){
            return $q->row();
        }
        return false;
    }
	
	public function getUnits(){
		$this->db->select()
				 ->from('units');
		$q = $this->db->get();
		if($q->num_rows() > 0){
			return $q->result();
		}
		return false;
	}
	
	public function getStrapByProductID($code = NULL) {
		$q = $this->db->get_where('related_products', array('product_code' => $code));
        if ($q->num_rows() > 0) {
            foreach (($q->result()) as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return FALSE;
	}
		public function getProductName_code($w_id=null)
    {	
		
		$this->db->where('warehouses_products.warehouse_id',$w_id);
		$this->db->select('concat(name," ( ",code," ) ") as label,code as value,erp_warehouses_products.quantity as quantity,products.cost as cost,erp_warehouses_products.quantity as qqh');
        $this->db->from('products');
		$this->db->join('warehouses_products' ,'warehouses_products.product_id=products.id', 'left');
		 $q = $this->db->get();
        if ($q->num_rows() > 0) {
            return $q->result();
        }
		return FALSE;
    }

    public function getAllChartAccountIn($section_id){
        $q = $this->db->query("SELECT
                                    accountcode,
                                    accountname,
                                    parent_acc,
                                    sectionid
                                FROM
                                    erp_gl_charts
                                WHERE
                                    sectionid IN ($section_id)");
        
        if ($q->num_rows() > 0) {
            return $q->result();
        }
        return FALSE;
    }
      
	public function getGLChart(){
		$this->db->select()
				 ->from('gl_charts');
		$q = $this->db->get();
		if($q->num_rows() > 0){
			return $q->result();
		}
		return false;
	}
	public function getUnitOfMeasureByProductCode($code,$unit_desc=null){
		if($unit_desc!=null){
			$this->db->where('units.name',$unit_desc);
		}
		$this->db->where('products.code',$code);
		$this->db->select('products.*,units.name as description, "1" as measure_qty');
		$this->db->from('products');
		$this->db->join('units','products.unit=units.id','left');
		$q=$this->db->get();
		if($q){
			if($unit_desc!=null){
				return $q->row();
			}else{
				return $q->result();
			}
			
		}
		return false;
	}
	public function getUnitOfMeasureByProductId($id,$unit_desc=null){
		if($unit_desc!=null){
			$this->db->where('units.name',$unit_desc);
		}
		$this->db->where('products.id',$id);
		$this->db->select('products.*,units.name as unit_variant, "1" as measure_qty');
		$this->db->from('products');
		$this->db->join('units','products.unit=units.id','left');
		$q=$this->db->get();
		if($q){
			if($unit_desc!=null){
				return $q->row();
			}else{
				return $q->result();
			}
			
		}
		return false;
	}
	
	public function insert_enter_using_stock($data, $ref_prefix){
		if($this->db->insert('enter_using_stock', $data)){
			$enter_using_stock_id = $this->db->insert_id();
            if ($this->site->getReference($ref_prefix) == $data['reference_no']) {
                $this->site->updateReference($ref_prefix, $data['shop']);
            }
			
			return true;
		}else{return false;}
	}
	public function insert_enter_using_stock_item($data){
		if($data) {
			$i=$this->db->insert('enter_using_stock_items', $data);
			if($i){
				return $this->db->insert_id();
			}
		}
		return false;
	}
	public function getProductQtyByCode($product_code)
    {	
		$this->db->where('code',$product_code);
		$this->db->select('*');
        $this->db->from('products');
		 $q = $this->db->get();
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return FALSE;
    }
	public function get_enter_using_stock_by_ref($ref){
		$this->db->select('enter_using_stock.*,warehouses.name,users.first_name,users.last_name');
		$this->db->from('enter_using_stock');
		$this->db->join('warehouses','warehouses.id=enter_using_stock.warehouse_id');
		$this->db->join('users','users.id=enter_using_stock.employee_id');
		$this->db->where('enter_using_stock.reference_no',$ref);
		$q=$this->db->get();
		if($q){
			return $q->row();
		}else{
			return false;
		}
	}	
	public function get_enter_using_stock_item_by_ref($ref){
		$this->db->select('enter_using_stock_items.*, products.name as product_name, expense_categories.name as exp_cate_name, enter_using_stock_items.unit as unit_name, products.cost, position.name as pname,reasons.description as rdescription, product_variants.qty_unit as variant_qty');
		$this->db->from('enter_using_stock_items');
		$this->db->join('products','products.code=enter_using_stock_items.code','left');
		$this->db->join('position','enter_using_stock_items.description = position.id','left');
		$this->db->join('reasons','enter_using_stock_items.reason = reasons.id','left');
		$this->db->join('product_variants','enter_using_stock_items.option_id = product_variants.id','left');
		$this->db->join('expense_categories','enter_using_stock_items.exp_cate_id = expense_categories.id','left');
		$this->db->where('enter_using_stock_items.reference_no',$ref);
		
		$q=$this->db->get();
		if($q){
			return $q->result();
		}else{
			return false;
		}
	}	
	function getReferno(){
		$q=$this->db->get('enter_using_stock');
		return $q->result();
	}
	function getEmpno(){
		$q=$this->db->get('erp_users');
		return $q->result();
	}
	function datatable_using_stock()
    {
        $this->load->library('datatables');
		
		$fdate=$this->input->get('fdate');
		$tdate=$this->input->get('tdate');
		
		$referno=$this->input->get('referno');
		$empno=$this->input->get('empno');
		//if($fdate=='' && $tdate==''){
		$start_date = $this->erp->fld($fdate);
        $end_date = $this->erp->fld($tdate);
		
        $this->datatables
            ->select("erp_enter_using_stock.id as id,erp_enter_using_stock.reference_no as refno,
			erp_companies.company,erp_warehouses.name as warehouse_name,erp_users.username,erp_enter_using_stock.note,
			erp_enter_using_stock.type as type,erp_enter_using_stock.date,erp_enter_using_stock.total_cost", FALSE)
            ->from("erp_enter_using_stock")
			
		    ->join('erp_companies', 'erp_companies.id=erp_enter_using_stock.shop', 'inner')
		    ->join('erp_warehouses', 'erp_enter_using_stock.warehouse_id=erp_warehouses.id', 'left')
			
			->join('erp_users', 'erp_users.id=erp_enter_using_stock.employee_id', 'inner');
			if($fdate!='' && $tdate!=''){
				$this->datatables->where('erp_enter_using_stock.date>=',$start_date);
				$this->datatables->where('erp_enter_using_stock.date<=',$end_date);
			}
			if($referno!=''){
				$this->datatables->where('erp_enter_using_stock.reference_no',$referno);
			}
			if($empno!=''){
				$this->datatables->where('erp_users.username',$empno);
			}
             $this->datatables->add_column("Actions", "<div class=\"text-center\">
			 <a class='edit_using' href='" . site_url('products/edit_enter_using_stock_by_id/$1/$2') . "'  class='tip' title='Edit'>
			 <i class=\"fa fa-edit\"></i>
			 </a>  
			 <a class='edit_return' href='" . site_url('products/edit_enter_using_stock_return_by_id/$1/$2') . "'  class='tip' title='Edit'>
			 <i class=\"fa fa-edit\"></i>
			 </a> 
			 <a href='" . site_url('products/print_enter_using_stock_by_id/$1/$2') . "'  class='tip' title='Print'>
			 <i class=\"fa fa-file-text-o\"></i>
			 </a> 
			 <a class='add_return' href='".site_url('products/return_enter_using_stock_by_id/$1') . "'  class='tip' title='Return'><i class=\"fa fa-reply\"></i></a>
			 ", "id,type");
			/* <a href='" . site_url('system_settings/edit_sale_type/$1') . "' data-toggle='modal' data-target='#myModal' class='tip' title='Edit'>
			 <i class=\"fa fa-edit\"></i>
			 </a> 
			 <a href='#' class='tip po' title='<b>" . lang("delete") . "</b>' data-content=\"<p>" . lang('r_u_sure') . "</p>
			 <a class='btn btn-danger po-delete' href='" . site_url('system_settings/delete_unit_of_saletype/$1') . "'>" . lang('i_m_sure') . "
			 </a> <button class='btn po-close'>" . lang('no') . "</button>\"  rel='popover'><i class=\"fa fa-trash-o\"></i>
			 </a>
			 </div>", "id,type");
			 */
        echo $this->datatables->generate();
    }
	public function getUsingStockById($id){
		$this->db->where('id',$id);
		$q=$this->db->get('enter_using_stock');
		if($q){
			return $q->row();
		}else{return false;}
	}
	public function getReturnReference($ref){
		$this->db->where('using_reference_no',$ref);
		$q=$this->db->get('enter_using_stock');
		if($q){
			return $q->row()->reference_no;
		}else{return false;}
	}
	
	public function getUsingStockItemByRef($ref,$wh_id=NULL){
		$this->db->select('enter_using_stock_items.id as e_id,
							enter_using_stock_items.code as product_code,
							enter_using_stock_items.description,
							enter_using_stock_items.reason,
							enter_using_stock_items.exp_cate_id,
							enter_using_stock_items.qty_use,
							enter_using_stock_items.qty_by_unit,
							enter_using_stock_items.unit,
							enter_using_stock_items.warehouse_id as wh_id,
							products.name,
							products.cost,
							products.code as product_code,
							products.id as product_id,
							sum(erp_warehouses_products.quantity) as quantity,
							products.unit as unit_type
						');
		$this->db->from('enter_using_stock_items');
		$this->db->join('products','enter_using_stock_items.code=products.code');
		$this->db->join('warehouses_products','products.id = warehouses_products.product_id');
		$this->db->where('enter_using_stock_items.reference_no', $ref);
			
		$this->db->group_by('e_id');
		$q=$this->db->get();
		if($q){
			return $q->result();
		}else{return false;}
	}
	
	public function getUsingStockItemsByRef($ref){
		$this->db->select('enter_using_stock_items.id as e_id,
							enter_using_stock_items.code as product_code,
							enter_using_stock_items.description,
							enter_using_stock_items.qty_use,
							enter_using_stock_items.qty_by_unit,
							enter_using_stock_items.unit,
							enter_using_stock_items.warehouse_id as wh_id,
							products.name,
							products.cost,
							products.quantity,
							products.code as product_code,
							products.id as product_id,
							warehouses_products.quantity as qoh,
							products.unit as unit_type,
							units.name as unit_name
						');
		$this->db->from('enter_using_stock_items');
		$this->db->join('products','enter_using_stock_items.code = products.code', 'left');
		$this->db->join('units','units.id = products.unit', 'left');
		$this->db->join('warehouses_products','enter_using_stock_items.warehouse_id = warehouses_products.warehouse_id and products.id = warehouses_products.product_id', 'left');
		$this->db->where('enter_using_stock_items.reference_no', $ref);
			
		$this->db->group_by('e_id');
		$q=$this->db->get();
		if($q){
			return $q->result();
		}else{
			return false;
		}
	}
	
	public function getUsingStockItems($ref){
		$this->db->select('enter_using_stock_items.id as e_id,
							enter_using_stock_items.code as product_code,
							enter_using_stock_items.description,
							enter_using_stock_items.reason,
							enter_using_stock_items.qty_use,
							enter_using_stock_items.qty_by_unit,
							enter_using_stock_items.unit,
							enter_using_stock_items.warehouse_id as wh_id,
							products.name,
							products.cost,
							products.quantity,
							products.code as product_code,
							products.id as product_id,
							warehouses_products.quantity as qoh,
							products.unit as unit_type,
							units.name as unit_name
						');
		$this->db->from('enter_using_stock_items');
		$this->db->join('products','enter_using_stock_items.code = products.code', 'left');
		$this->db->join('units','units.id = products.unit', 'left');
		$this->db->join('warehouses_products','enter_using_stock_items.warehouse_id = warehouses_products.warehouse_id and products.id = warehouses_products.product_id', 'left');
		$this->db->where('enter_using_stock_items.reference_no', $ref);
			
		$this->db->group_by('e_id');
		$q=$this->db->get();
		if($q){
			return $q->result();
		}else{return false;}
	}
	
	public function getReturnStockItem($ref, $code)
	{
		$q = $this->db->select('qty_by_unit as return_qty')->from('enter_using_stock_items')->where(array('reference_no'=>$ref, 'code'=>$code))->get()->row()->return_qty;
		if($q){
			return $q;
		}
		return false;
		
	}
	public function getQtyOnHandGroupByWhID(){
		$this->db->select('warehouses_products.id,warehouses_products.product_id,warehouses_products.warehouse_id,sum(erp_warehouses_products.quantity) as qqh,products.code as product_code');
		$this->db->from('warehouses_products');
		$this->db->Group_by('warehouse_id');
		$this->db->Group_by('product_id');
		$this->db->join('products','warehouses_products.product_id=products.id');
		$q=$this->db->get();
		if($q){
			return $q->result();
		}else{return false;}
	}
	public function update_enter_using_stock($data,$ref_prefix,$stock_id){
		$this->db->where('id',$stock_id);
		if($this->db->update('enter_using_stock', $data)){
			return true;
		}else{
			return false;
		}
	}
	public function delete_purchase_items_by_ref($reference_no){
		$this->db->where('reference', $reference_no);
		$d=$this->db->delete('purchase_items');
		if($d){
			return true;
		}return false;
	}
	public function delete_purchase_items_by_conId($id){
		$this->db->where('transaction_id', $id);
		$d=$this->db->delete('purchase_items');
		if($d){
			return true;
		}return false;
	}
	public function delete_inventory_valuation_details($stock_item_id_arr){
		foreach($stock_item_id_arr as $id){
			$this->db->delete("inventory_valuation_details",array('field_id'=>$id));
		}
		return true;
	}
	public function delete_enter_items_by_ref($reference_no){
		$this->db->where('reference_no', $reference_no);
		$d=$this->db->delete('enter_using_stock_items');
		if($d){
			return true;
		}return false;
	}
	public function update_enter_using_stock_item($data,$item_id){
		$this->db->where('id',$item_id);
		$i = $this->db->update('enter_using_stock_items', $data);
		if($i){
			return true;
		}else{return false;}
	}
	public function delete_update_stock_item($id){
		$d = $this->db->delete('enter_using_stock_items', array('id' => $id));
	}
	public function get_enter_using_stock_by_id($id){
		$this->db->select('enter_using_stock.*,warehouses.name,users.first_name,users.last_name');
		$this->db->from('enter_using_stock');
		$this->db->join('warehouses','warehouses.id=enter_using_stock.warehouse_id');
		$this->db->join('users','users.id=enter_using_stock.employee_id');
		$this->db->where('enter_using_stock.id',$id);
		$q=$this->db->get();
		if($q){
			return $q->row();
		}else{
			return false;
		}
	}
	public function getUsingStockItem($item_code,$reference_no){
		$this->db->where('code',$item_code);
		$this->db->where('reference_no',$reference_no);
		$q=$this->db->get('enter_using_stock_items');
		if($q){
			return $q->row();
		}return false;
	}
	public function getUsingStockReturnItemByRef($ref,$wh_id=NULL){
		$this->db->select('enter_using_stock_items.id as e_id,
									enter_using_stock_items.code as product_code,
									enter_using_stock_items.description,
									enter_using_stock_items.reason,
									enter_using_stock_items.qty_use,
									enter_using_stock_items.qty_by_unit,
									enter_using_stock_items.unit,
									enter_using_stock_items.warehouse_id as wh_id,
									products.name,
									products.cost,
									products.code as product_code,
									products.id as product_id,
									sum(erp_warehouses_products.quantity) as quantity,
									products.unit as unit_type,
									,erp_enter_using_stock_items.qty_use as qty_use_from_using_stock
									
						');
		$this->db->from('enter_using_stock_items');
		$this->db->join('products','enter_using_stock_items.code=products.code');
		$this->db->join('warehouses_products','products.id=warehouses_products.product_id');
		$this->db->join('enter_using_stock','enter_using_stock_items.reference_no=enter_using_stock.reference_no');
		$this->db->where('enter_using_stock_items.reference_no',$ref);
		
		
		$this->db->group_by('e_id');
		$q=$this->db->get();
		if($q){
			return $q->result();
		}else{return false;}
	}
	  public function get_all_enter_using_stock($id) {
		$this->db->select('enter_using_stock.*,users.username,companies.company,warehouses.name as warehouse_name,users.first_name,users.last_name');
    //  $this->db->from('enter_using_stock');
        $this->db->join('warehouses', 'warehouses.id=enter_using_stock.warehouse_id',left);
        $this->db->join('users', 'users.id=enter_using_stock.employee_id',inner);
        $this->db->join('companies', 'companies.id = enter_using_stock.shop',inner);
        $q = $this->db->get_where('enter_using_stock', array('enter_using_stock.id' => $id), 1);
    if ($q->num_rows() > 0) {
        return $q->row();
    }
    return FALSE;
    }
	
	public function getPurcahseItemByPurchaseID($id)
    {
		$this->db->select('products.code, products.name, products.cost, products.quantity, (erp_products.cost * erp_products.quantity) AS total_cost, products.unit, units.name as uname');
		$this->db->from('purchase_items');
		$this->db->join('products','products.id = purchase_items.product_id', 'left');
		$this->db->join('units','units.id = products.unit', 'left');
		$this->db->where('purchase_id', $id);
        $q = $this->db->get();
        if ($q->num_rows() > 0) {
            return $q->result();
        }
        return FALSE;
    }
	
	public function getPurchaseByID($id)
    {
        $q = $this->db->get_where('purchases', array('id' => $id), 1);
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return FALSE;
    }	
	
	public function getProduct(){
		
		$this->db->select("products.id,	CONCAT(erp_products.code,' - ',erp_products.name) AS name,
							COALESCE(SUM(CASE WHEN erp_purchase_items.purchase_id <> 0 THEN (erp_purchase_items.quantity*(CASE WHEN erp_product_variants.qty_unit <> 0 THEN erp_product_variants.qty_unit ELSE 1 END)) ELSE 0 END),0) as purchasedQty,
							SUM( erp_sale_items.quantity*(CASE WHEN erp_product_variants.qty_unit <> 0 THEN erp_product_variants.qty_unit ELSE 1 END)) soldQty,
							
							");					
				
					$this->db->from('products');					
					$this->db->group_by("products.id");	
					$this->db->join('sale_items','sale_items.product_id = products.id', 'left');
					$this->db->join('product_variants','product_variants.product_id = products.id', 'left');
					$this->db->join('purchase_items', 'purchase_items.product_id = products.id', 'left');				
					$this->db->join('warehouses_products', 'warehouses_products.product_id=products.id', 'left');
					$this->db->join('categories', 'products.category_id=categories.id', 'left');
					$q = $this->db->get();
					if ($q->num_rows() > 0) {
						foreach (($q->result()) as $row) {
							$data[] = $row;
						}
						return $data;
					}
					return FALSE;
	}
	
	public function getProductsReportTable($biller_id = NULL,$param = NULL){
			
		if ($param['product']) {
            $product = $param['product'];
        } else {
            $product = NULL;
        }
		
		if ($param['biller_id']) {
            $biller_id = $param['biller_id'];
        } else {
            $biller_id = NULL;
        }

        if ($param['category']) {
            $category = $param['category'];
        } else {
            $category = NULL;
        }
		if ($param['supplier']) {
            $supplier = $param['supplier'];
        } else {
            $supplier = NULL;
        }
		
		if ($param['start_date']) {
            $start_date = $param['start_date'];
        } else {
            $start_date = NULL;
        }
		
		if ($param['end_date']) {
            $end_date = $param['end_date'];
        } else {
            $end_date = NULL;
        }
		if ($param['warehouse']) {
            $warehouse = $param['warehouse'];
			$where_sale=$param['where_sale'];
			$where_purchase=$param['where_purchase'];
        } else {
            $warehouse = NULL;
			$where_purchase = '';
			$where_sale='';
        }
		
		if($biller_id){
			$where_p_biller = "AND p.biller_id = {$biller_id} ";
			$where_s_biller = "AND s.biller_id = {$biller_id} ";
		}else{
			$where_p_biller = 'AND 1=1 ';
			$where_s_biller = 'AND 1=1 ';
		}
		
        if ($start_date) {
            $start_date = $this->erp->fld($start_date);
			//echo $start_date; die();
            $end_date = $end_date ? $this->erp->fld($end_date) : date('Y-m-d');
			
			
			
			$pp = "( SELECT 
				pi.date as date, pi.product_id, 
				pi.purchase_id, 
				COALESCE(SUM( CASE WHEN pi.purchase_id <> 0 THEN (pi.quantity*(CASE WHEN ppv.qty_unit <> 0 THEN ppv.qty_unit ELSE 1 END)) ELSE 0 END),0) as purchasedQty, 
				SUM(pi.quantity_balance) as balacneQty, 
				SUM((CASE WHEN pi.option_id <> 0 THEN ppv.cost ELSE pi.net_unit_cost END) * pi.quantity_balance ) balacneValue, 
				SUM( pi.unit_cost * (CASE WHEN pi.purchase_id <> 0 THEN pi.quantity ELSE 0 END) ) totalPurchase 
				FROM {$this->db->dbprefix('purchase_items')} pi 
				LEFT JOIN {$this->db->dbprefix('purchases')} p 
				on p.id = pi.purchase_id 
				LEFT JOIN " . $this->db->dbprefix('product_variants') . " ppv 
				ON ppv.id=pi.option_id 
				WHERE p.date >= '{$start_date}' and p.date < '{$end_date}' 
				AND pi.status <> 'ordered'
				". $where_p_biller ."
				GROUP BY pi.product_id ) PCosts";
				
			$sp = "( SELECT si.product_id, 
				SUM( si.quantity*(CASE WHEN pv.qty_unit <> 0 THEN pv.qty_unit ELSE 1 END)) soldQty, 
				SUM( si.subtotal ) totalSale, 
				s.date as sdate 
				FROM " . $this->db->dbprefix('sales') . " s 
				INNER JOIN " . $this->db->dbprefix('sale_items') . " si 
				ON s.id = si.sale_id 
				LEFT JOIN " . $this->db->dbprefix('product_variants') . " pv 
				ON pv.id=si.option_id 
				WHERE s.date >= '{$start_date}' 
				AND s.date < '{$end_date}' 
				". $where_s_biller ."
				GROUP BY si.product_id ) PSales";
			
        } else {
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
						". $where_p_biller ."
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
						". $where_s_biller ."
						GROUP BY si.product_id ) PSales";
        }
		return array($param,$pp,$sp);
        
	}
	
	
    public function getStockCountProducts($warehouse_id, $type, $categories = NULL, $brands = NULL)
    {
        $this->db->select("{$this->db->dbprefix('products')}.id as id, {$this->db->dbprefix('products')}.code as code, {$this->db->dbprefix('products')}.name as name, {$this->db->dbprefix('warehouses_products')}.quantity as quantity")
        ->join('warehouses_products', 'warehouses_products.product_id=products.id', 'left')
        ->where('warehouses_products.warehouse_id', $warehouse_id)
        ->where(array('products.type'=>'standard', 'products.inactived != ' => '1'))
        ->order_by('products.code', 'asc');
        if ($categories) {
            $r = 1;
            $this->db->group_start();
            foreach ($categories as $category) {
                if ($r == 1) {
                    $this->db->where('products.category_id', $category);
                } else {
                    $this->db->or_where('products.category_id', $category);
                }
                $r++;
            }
            $this->db->group_end();
        }
        if ($brands) {
            $r = 1;
            $this->db->group_start();
            foreach ($brands as $brand) {
                if ($r == 1) {
                    $this->db->where('products.brand', $brand);
                } else {
                    $this->db->or_where('products.brand', $brand);
                }
                $r++;
            }
            $this->db->group_end();
        }

        $q = $this->db->get('products');
        if ($q->num_rows() > 0) {
            foreach (($q->result()) as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return FALSE;
    }

    public function getStockCountProductVariants($warehouse_id, $product_id)
    {
        $this->db->select("{$this->db->dbprefix('product_variants')}.name, {$this->db->dbprefix('warehouses_products_variants')}.quantity as quantity")
            ->join('warehouses_products_variants', 'warehouses_products_variants.option_id=product_variants.id', 'left');
        $q = $this->db->get_where('product_variants', array('product_variants.product_id' => $product_id, 'warehouses_products_variants.warehouse_id' => $warehouse_id));
        if ($q->num_rows() > 0) {
            foreach (($q->result()) as $row) {
                $data[] = $row;
            }
            return $data;
        }
    }

    public function addStockCount($data)
    {
        if ($this->db->insert('stock_counts', $data)) {
            return TRUE;
        }
        return FALSE;
    }

    public function finalizeStockCount($id, $data, $products)
    {
        if ($this->db->update('stock_counts', $data, array('id' => $id))) {
            foreach ($products as $product) {
                $this->db->insert('stock_count_items', $product);
            }
            return TRUE;
        }
        return FALSE;
    }

    public function getStouckCountByID($id)
    {
        $q = $this->db->get_where("stock_counts", array('id' => $id), 1);
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return FALSE;
    }

    public function getStockCountItems($stock_count_id)
    {
        $q = $this->db->get_where("stock_count_items", array('stock_count_id' => $stock_count_id));
        if ($q->num_rows() > 0) {
            foreach (($q->result()) as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return NULL;
    }
	
	 public function getAdjustmentByCountID($count_id)
    {
        $q = $this->db->get_where('adjustments', array('count_id' => $count_id), 1);
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return FALSE;
    }

    public function getProductVariantID($product_id, $name)
    {
        $q = $this->db->get_where("product_variants", array('product_id' => $product_id, 'name' => $name), 1);
        if ($q->num_rows() > 0) {
            $variant = $q->row();
            return $variant->id;
        }
        return NULL;
    }
	
	public function deleteProductPhoto($id)
    {
        if ($this->db->delete('product_photos', array('id' => $id))) {
            return true;
        }
        return FALSE;
    }
	public function addStock($data, $product){
		$this->erp->print_arrays($data, $product);
		$this->db->insert_batch('purchase_items', $data);
		foreach($product as $product_id){
			$this->site->syncQuantitys(NULL,  NULL, NULL, $product_id);
		}
	}
	public function getProductByWareId($w_id=null, $c_id = null)
    {	
		if($c_id){
			$this->db->where('products.category_id',$c_id);
		}
		$this->db->where(array('warehouses_products.warehouse_id'=>$w_id, 'products.inactived !='=>'1'));
		$this->db->select('products.id as pid, products.code, products.name as label, COALESCE(erp_product_variants.name, "") as variant, warehouses_products.quantity as quantity, 0 as qty');
        $this->db->from('products');
		$this->db->join('warehouses_products' ,'warehouses_products.product_id=products.id', 'left');
		$this->db->join('product_variants' ,'product_variants.product_id=products.id', 'left');
		$q = $this->db->get();
        if ($q->num_rows() > 0) {
            return $q->result();
        }
		return FALSE;
    }
	
	public function getReasonsForPositionID($position_id)
    {
        $this->db->select('id as id, description as text');
        $q = $this->db->get_where("reasons", array('position_id' => $position_id));
        if ($q->num_rows() > 0) {
            foreach (($q->result()) as $row) {
                $data[] = $row;
            }

            return $data;
        }

        return FALSE;
    }
	
	//=========================== Enter Using Stock =======================//
	
	public function getAllExpenseCategory()
    {
        $q = $this->db->get('expense_categories');
        if ($q->num_rows() > 0) {
			return $q->result();
        }
        return FALSE;
    }
	
	public function getAllreasons()
    {
        $q = $this->db->get('reasons');
        if ($q->num_rows() > 0) {
			return $q->result();
        }
        return FALSE;
    }
	
	public function getAllPositionData() {
		$q = $this->db->get('position');
		if ($q->num_rows() > 0 ) {
			$data = $q->result();
			return $data;
		}
		return FALSE;
	}
	
	//================================== End ==============================//
	
	//========================== Edit Multi Adjustment =====================//
	
	public function getAdjustmentItems($adjustment_id)
    {
        $this->db->select('adjustment_items.*, products.code as product_code, products.name as product_name, products.image, products.details as details, product_variants.name as variant')
            ->join('products', 'products.id=adjustment_items.product_id', 'left')
            ->join('product_variants', 'product_variants.id=adjustment_items.option_id', 'left')
            ->group_by('adjustment_items.id')
            ->order_by('id', 'asc');

        $this->db->where('adjust_id', $adjustment_id);

        $q = $this->db->get('adjustment_items');
        if ($q->num_rows() > 0) {
            foreach (($q->result()) as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return FALSE;
    }
	
	public function updateMultiAdjustment($id, $data, $dataPurchase = NULL,$itemid)
    {
		
        if ($this->db->update('adjustments', $data, array('id' => $id))) {
			$quantity_balance = 0;
			$pro_db_id  = array();
			$pro_in_id  = array();
			$pro_merge  = array();
			$pro_unique = array();
			
			$adjust_item = $this->getAdjustmentItems($id);
			
			foreach($adjust_item as $items){
				$pro_db_id[] = $items->product_id;
			}
			
			foreach($dataPurchase as $items){
				$pro_in_id[] = $items['product_id'];
			}
			
			$pro_merge = array_merge($pro_db_id, $pro_in_id);
			$pro_unique = array_unique($pro_merge);
			
			// delete inventoryItem
			$adjustItems = $this->site->getAdjustmentItemByID($id);
			
			foreach($adjustItems as $adjustItem){
				$inventoryItem = $this->site->getInventoryItemByAdjItem($adjustItem->id, 'ADJUSTMENT');
				if($inventoryItem){
					foreach($inventoryItem as $invItem){
						$this->db->delete('inventory_valuation_details', array('id' => $invItem->id));
					}
				}
			}
			
			foreach($adjustItems as $adjustItem){
				$purchase_item = $this->site->getPurchaseItemByAdjID($adjustItem->id, 'ADJUSTMENT');
				if($purchase_item){
					$this->db->delete('purchase_items', array('id' => $purchase_item->id));
				}
			}
			
			$this->db->delete('adjustment_items', array('adjust_id'=>$id));
			
			foreach($dataPurchase as $products){
				$products['adjust_id'] 	= $id;
				$quantity_balance 		= $products['quantity_balance'];
				unset($products['quantity_balance']);
                $this->db->insert('adjustment_items', $products);
				$adjust_item_id 		= $this->db->insert_id();
				
				unset($products['adjust_id']);
				unset($products['cost']);
				unset($products['total_cost']);
				unset($products['type']);
				unset($products['biller_id']);
				$products['date'] = date("Y-m-d");
				$products['quantity_balance'] 	= $quantity_balance;
				$products['transaction_id'] 	= $adjust_item_id;
				$products['transaction_type'] 	= 'ADJUSTMENT';
				$products['status'] 			= 'received';

				$this->db->insert('purchase_items', $products);	
				$product_cost = $this->site->getProductByID($products['product_id']);
				$this->db->update("inventory_valuation_details",array('cost'=>$product_cost->cost,'avg_cost'=>$product_cost->cost,'date'=>date("Y-m-d H:i:s"),'reference_no'=>$data['reference_no']),array('field_id'=>$adjust_item_id));
			}
			foreach($pro_unique as $product_id){
				$this->site->syncQuantitys(null, null, null, $product_id);
			}			
			return true;
        }
        return false;
    }
	
	public function getAdjustQtyFromWare($adjust_id, $product_id){
		$this->db->select('warehouses_products.quantity')
				 ->from('adjustments')
				 ->join('warehouses_products', 'warehouses_products.warehouse_id = adjustments.warehouse_id')
				 ->where(array('adjustments.id' => $adjust_id,'warehouses_products.product_id'=>$product_id));
		$q = $this->db->get();
		if ($q->num_rows() > 0 ) {
			return $q->row();
		}
		return FALSE;
	}
	//================================= End ================================//

}
