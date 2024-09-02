<?php
class MasterMemberShipRateModel extends CI_Model
{
    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    function fetch_all()
    {
        $this->db->select('tbl_master_membership_category_rates.*,tbl_master_currency.currency AS currency_name, tbl_master_membership_category_rates_document.document AS document');
        $this->db->from('tbl_master_membership_category_rates');
        $this->db->join('tbl_master_currency','tbl_master_currency.symbol = tbl_master_membership_category_rates.currency');
        $this->db->join('tbl_master_membership_category_rates_document','tbl_master_membership_category_rates_document.membership_rate_id = tbl_master_membership_category_rates.id','left'); 
        $query=$this->db->get(); 
		return $query->result(); 
    }

    function fetchallcategory()
    {
        $this->db->select('*');
        $this->db->from('tbl_master_membership_category'); 
        $this->db->where("status",'Active');
        $query=$this->db->get(); 
		return $query->result(); 
    }

    function fetchallcurrencies()
    {
        $this->db->select('tbl_master_currency.*');
        $this->db->from('tbl_master_currency');  
        $query=$this->db->get(); 
		return $query->result(); 
    }

    function fetchalldurations()
    {
        $this->db->select('tbl_master_duration.*');
        $this->db->from('tbl_master_duration');  
        $query=$this->db->get(); 
		return $query->result(); 
    }
    
    function insert_api($data)
    {
        $this->db->insert('tbl_master_membership_category_rates', $data);
        if ($this->db->affected_rows() > 0) {
        return $this->db->insert_id();
        } else {
            return false;
        }
    }

    function insert_api2($data2)
    {
        $this->db->insert('tbl_master_membership_category_rates_document', $data2);
        if ($this->db->affected_rows() > 0) {
        return true;
        } else {
            return false;
        }
    }

    function fetchDocuments($id)
    {
        $this->db->where('membership_rate_id', $id);  
        $query=$this->db->get('tbl_master_membership_category_rates_document'); 
		return $query->row(); 
    }
       
    function fetch_single_data($id)
    {
        $this->db->select('tbl_master_membership_category_rates.*,tbl_master_currency.symbol AS currency_name ');
        $this->db->from('tbl_master_membership_category_rates');
        $this->db->join('tbl_master_currency','tbl_master_currency.id=tbl_master_membership_category_rates.currency'); 
        $this->db->where("tbl_master_membership_category_rates.id", $id);
        $query=$this->db->get(); 
        return $query->row();
    }

    function fetch_category_data($id)
    {
        $this->db->where("name", $id);
        $query = $this->db->get('tbl_master_membership_category');
        return $query->row();
    }

    function update_data($id, $data)
    {
        $this->db->where("id", $id);
        return $this->db->update("tbl_master_membership_category_rates", $data);
    }

    function update_data2($id, $data)
    {
        $this->db->where("membership_rate_id", $id);
        return $this->db->update("tbl_master_membership_category_rates_document", $data);
    }

    function delete_document($id)
    {
        return $this->db->delete('tbl_master_membership_category_rates_document', ['membership_rate_id' => $id]);
    }

    function delete_single_data($id)
    {
        $this->db->select("category");
        $this->db->where("id", $id);
        $query = $this->db->get("tbl_master_membership_category_rates");

        if ($query->num_rows() == 0) {
            return false;
        }

        $row = $query->row();
        $category = $row->category;

        $tables = $this->db->list_tables();

        foreach ($tables as $table) {
            if ($table !== 'tbl_master_membership_category_rates') {
                $columns = $this->db->list_fields($table);
                foreach ($columns as $column) {
                    $this->db->where($column, $category);
                    $query = $this->db->get($table);

                    if ($query->num_rows() > 0) {
                        return false;
                    }
                }

                $this->db->delete('tbl_master_membership_category_rates', ['id' => $id]);
                return true;
            }
        }
    }

    function get_title($code)
    {
        $query=$this->db->get_where('tbl_master_membership_category', array('code' => $code)); 
        if ($query->num_rows() > 0) {
            $row = $query->row();
            return $row->title;
        } else {
            return null; // or any appropriate value if no matching record is found
        }
    }

    function get_type($code)
    {
        $query=$this->db->get_where('tbl_master_membership_category', array('code' => $code)); 
        if ($query->num_rows() > 0) {
            $row = $query->row();
            return $row->type;
        } else {
            return null; // or any appropriate value if no matching record is found
        }
    }

    function get_file($id)
    {
        $query=$this->db->get_where('tbl_master_membership_category_rates_document', array('membership_rate_id' => $id)); 
        if ($query->num_rows() > 0) {
            $row = $query->row();
            return $row->document;
        } else {
            return null; // or any appropriate value if no matching record is found
        }
    }

    function getByCategory( $category_id ) 
    {
        $this->db->where('category', $category_id);
        $query = $this->db->get('tbl_master_membership_category_rates'); 
        return $query->num_rows() > 0;
    }

    function getByCategoryByID( $id, $category_id ) 
    {
        $this->db->where('id!=', $id);
        $this->db->group_start();
        $this->db->where('category', $category_id);
        $this->db->group_end();
        $query = $this->db->get('tbl_master_membership_category_rates'); 
        return $query->num_rows() > 0;
    }
    
}