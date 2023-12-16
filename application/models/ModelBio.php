<?php
defined('BASEPATH') or exit('No direct script access allowed');

class ModelBio extends CI_Model
{
    public function simpanData($data = null)
    {
        $this->db->insert('biodata', $data);
    }

    public function simpanBio($data = null)
    {
        $this->db->insert('biodata_saya', $data);
    }

    public function getBio()
    {
        return $this->db->get('biodata_saya');
    }

    public function bioWhere($where)
    {
        return $this->db->get_where('biodata_saya', $where);
    }

    public function updateBiodata($data = null, $where = null)
    {
        $this->db->update('biodata_saya', $data, $where);
    }

    public function hapusBiodata($where = null)
    {
        $this->db->delete('biodata_saya', $where);
    }
}
