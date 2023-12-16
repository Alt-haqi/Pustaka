<?php

class Biodata extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model(['ModelBio', 'ModelUser']);
    }

    public function simpan_bio()
    {
        $data = [
            'nim' => htmlspecialchars($this->input->post('nim', true)),
            'nama' => htmlspecialchars($this->input->post('nama', true)),
        ];

        $this->ModelBio->simpanData($data);
        $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-message" role="alert">Selamat!! akun anggota anda sudah dibuat.</div>');
        redirect(base_url());
    }

    //manajemen Bio
    public function index()
    {
        $data['judul'] = 'Biodata Saya';
        $data['user'] = $this->ModelUser->cekData(['email' => $this->session->userdata('email')])->row_array();
        $data['biodata_saya'] = $this->ModelBio->getBio()->result_array();

        $this->form_validation->set_rules('nim', 'NIM', 'required|min_length[3]|numeric', [
            'required' => 'NIM harus diisi',
            'min_length' => 'NIM terlalu pendek',
            'numeric' => 'Yang anda masukan bukan angka'
        ]);
        $this->form_validation->set_rules('nama', 'Nama', 'required|min_length[3]', [
            'required' => 'Nama harus diisi',
            'min_length' => 'Nama terlalu pendek'
        ]);
        $this->form_validation->set_rules('alamat', 'Alamat', 'required|min_length[3]', [
            'required' => 'Alamat harus diisi',
            'min_length' => 'Alamat terlalu pendek'
        ]);
        $this->form_validation->set_rules('jenis_kelamin', 'Jenis Kelamin', 'required', [
            'required' => 'Jenis Kelamin harus diisi',
        ]);
        $this->form_validation->set_rules('hobby', 'Hobby', 'required|min_length[3]', [
            'required' => 'Hobby harus diisi',
            'min_length' => 'Hobby terlalu pendek'
        ]);

        //konfigurasi sebelum gambar diupload
        $config['upload_path'] = './assets/img/upload/';
        $config['allowed_types'] = 'jpg|png|jpeg';
        $config['max_size'] = '2048';
        $config['max_width'] = '1024';
        $config['max_height'] = '1000';
        $config['file_name'] = 'img' . time();

        $this->load->library('upload', $config);

        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('biodata/index', $data);
            $this->load->view('templates/footer');
        } else {
            if ($this->upload->do_upload('photo')) {
                $photo = $this->upload->data();
                $gambar = $photo['file_name'];
            } else {
                $gambar = '';
            }
            /*$filename = $_FILES["image"]["name"]; //mendapatkan nama file
            $ext_list = array("jpg", "png", "jpeg"); //membatasi jenis image yang bisa diupload
            $pisah = explode(".", $filename); //memisahkan nama file dengan extention
            $namaimage = 'img' . time() . in_array($pisah[1], $ext_list); //menghasilkan nama image baru
            move_uploaded_file($_FILES["image"]["tmp_name"], base_url('assets/img/upload/') . $namaimage);*/

            $data = [
                'nim' => $this->input->post('nim', true),
                'nama' => $this->input->post('nama', true),
                'alamat' => $this->input->post('alamat', true),
                'jenis_kelamin' => $this->input->post('jenis_kelamin', true),
                'hobby' => $this->input->post('hobby', true),
                'photo' => $gambar
            ];

            $this->ModelBio->simpanBio($data);
            redirect('biodata');
        }
    }


    public function hapusBiodata()
    {
        $where = ['id' => $this->uri->segment(3)];
        $this->ModelBio->hapusBiodata($where);
        redirect('biodata');
    }

    public function ubahBiodata()
    {
        $data['judul'] = 'Ubah Biodata';
        $data['user'] = $this->ModelUser->cekData(['email' => $this->session->userdata('email')])->row_array();
        $data['biodata_saya'] = $this->ModelBio->bioWhere(['id' => $this->uri->segment(3)])->result_array();

        $this->form_validation->set_rules('nim', 'NIM', 'required|min_length[3]|numeric', [
            'required' => 'NIM harus diisi',
            'min_length' => 'NIM terlalu pendek',
            'numeric' => 'Yang anda masukan bukan angka'
        ]);
        $this->form_validation->set_rules('nama', 'Nama', 'required|min_length[3]', [
            'required' => 'Nama harus diisi',
            'min_length' => 'Nama terlalu pendek'
        ]);
        $this->form_validation->set_rules('alamat', 'Alamat', 'required|min_length[3]', [
            'required' => 'Alamat harus diisi',
            'min_length' => 'Alamat terlalu pendek'
        ]);
        $this->form_validation->set_rules('jenis_kelamin', 'Jenis Kelamin', 'required', [
            'required' => 'Jenis Kelamin harus diisi',
        ]);
        $this->form_validation->set_rules('hobby', 'Hobby', 'required|min_length[3]', [
            'required' => 'Hobby harus diisi',
            'min_length' => 'Hobby terlalu pendek'
        ]);

        //konfigurasi sebelum gambar diupload
        $config['upload_path'] = './assets/img/upload/';
        $config['allowed_types'] = 'jpg|png|jpeg';
        $config['max_size'] = '3096';
        $config['max_width'] = '1024';
        $config['max_height'] = '1000';
        $config['file_name'] = 'img' . time();

        //memuat atau memanggil library upload
        $this->load->library('upload', $config);

        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('biodata/ubah_bio', $data);
            $this->load->view('templates/footer');
        } else {
            if ($this->upload->do_upload('photo')) {
                $photo = $this->upload->data();
                unlink('assets/img/upload/' . $this->input->post('old_pict', TRUE));
                $gambar = $photo['file_name'];
            } else {
                $gambar = $this->input->post('old_pict', TRUE);
            }
            /*$filename = $_FILES['image']['name']; //mendapatkan nama file
            $ext_list = array('jpg', 'png', 'jpeg'); //membatasi jenis image yang bisa diupload
            $pisah = explode('.', $filename); //memisahkan nama file dengan extention
            $namaimage = 'img' . time() . in_array($pisah[1], $ext_list); //menghasilkan nama image baru
            move_uploaded_file($_FILES['image']['tmp_name'], base_url('./assets/img/upload') . $namaimage);
            unlink('assets/img/upload/' . $this->input->post('old_pict', TRUE));*/

            $data = [
                'nim' => $this->input->post('nim', true),
                'nama' => $this->input->post('nama', true),
                'alamat' => $this->input->post('alamat', true),
                'jenis_kelamin' => $this->input->post('jenis_kelamin', true),
                'hobby' => $this->input->post('hobby', true),
                'photo' => $gambar
            ];

            $this->ModelBio->updateBiodata($data, ['id' => $this->input->post('id')]);
            redirect('biodata');
        }
    }
}
?>