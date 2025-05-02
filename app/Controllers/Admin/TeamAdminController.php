<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\CommentModel;
use App\Models\InboxModel;
use App\Models\TeamModel;

class TeamAdminController extends BaseController
{
    public function __construct()
    {
        $this->inboxModel = new InboxModel();
        $this->commentModel = new CommentModel();

        $this->TeamModel = new TeamModel();
    }
    public function index()
    {
        $data = [
            'akun' => $this->akun,
            'title' => 'All Team',
            'active' => $this->active,
            'total_inbox' => $this->inboxModel->where('inbox_status', 0)->get()->getNumRows(),
            'inboxs' => $this->inboxModel->where('inbox_status', 0)->findAll(),
            'total_comment' => $this->commentModel->where('comment_status', 0)->get()->getNumRows(),
            'comments' => $this->commentModel->where('comment_status', 0)->findAll(),
            'helper_text' => helper('text'),
            'breadcrumbs' => $this->request->getUri()->getSegments(),

            'Teams' => $this->TeamModel->findAll()
        ];

        return view('admin/v_Team', $data);
    }
    public function insert()
    {
        if (!$this->validate([
            'nama' => [
                'rules' => 'required|alpha_space',
                'errors' => [
                    'required' => 'Kolom {field} harus diisi!',
                    'alpha_space' => 'inputan tidak boleh mengandung karakter aneh'
                ]
            ],
            'jabatan' => [
                'rules' => 'required|alpha_space',
                'errors' => [
                    'required' => 'Kolom {field} harus diisi!',
                    'alpha_space' => 'inputan tidak boleh mengandung karakter aneh'
                ]
            ],
            'twitter' => [
                'rules' => 'required|valid_url_strict',
                'errors' => [
                    'required' => 'Kolom {field} harus diisi!',
                    'valid_url_strict' => 'Inputan harus berformat url'
                ]
            ],
            'facebook' => [
                'rules' => 'required|valid_url_strict',
                'errors' => [
                    'required' => 'Kolom {field} harus diisi!',
                    'valid_url_strict' => 'Inputan harus berformat url'
                ]
            ],
            'instagram' => [
                'rules' => 'required|valid_url_strict',
                'errors' => [
                    'required' => 'Kolom {field} harus diisi!',
                    'valid_url_strict' => 'Inputan harus berformat url'
                ]
            ],
            'linked' => [
                'rules' => 'required|valid_url_strict',
                'errors' => [
                    'required' => 'Kolom {field} harus diisi!',
                    'valid_url_strict' => 'Inputan harus berformat url'
                ]
            ],
            'filefoto' => [
                'rules' => 'max_size[filefoto,2048]|is_image[filefoto]|mime_in[filefoto,image/jpg,image/jpeg,image/png]',
                'errors' => [
                    'max_size' => 'Ukuran gambar tidak boleh lebih dari 2MB',
                    'is_image' => 'Yang anda pilih bukan gambar',
                    'mime_in' => 'Yang anda pilih bukan gambar'
                ]
            ]
        ])) {
            return redirect()->to('/admin/Team')->with('msg', 'error');
        }
        // Cek foto
        if ($this->request->getFile('filefoto')->isValid()) {
            // Ambil File foto
            $fotoUpload = $this->request->getFile('filefoto');
            $namaFotoUpload = $fotoUpload->getRandomName();
            $fotoUpload->move('assets/backend/images/Team/', $namaFotoUpload);
        } else {
            $namaFotoUpload = 'user_blank.jpg';
        }
        $nama = strip_tags(htmlspecialchars($this->request->getPost('nama'), ENT_QUOTES));
        $jabatan = strip_tags(htmlspecialchars($this->request->getPost('jabatan'), ENT_QUOTES));
        $twitter = strip_tags(htmlspecialchars($this->request->getPost('twitter'), ENT_QUOTES));
        $facebook = strip_tags(htmlspecialchars($this->request->getPost('facebook'), ENT_QUOTES));
        $instagram = strip_tags(htmlspecialchars($this->request->getPost('instagram'), ENT_QUOTES));
        $linked = strip_tags(htmlspecialchars($this->request->getPost('linked'), ENT_QUOTES));
        // Simpan ke database
        $this->TeamModel->save([
            'Team_name' => $nama,
            'Team_jabatan' => $jabatan,
            'Team_twitter' => $twitter,
            'Team_facebook' => $facebook,
            'Team_instagram' => $instagram,
            'Team_linked' => $linked,
            'Team_image' => $namaFotoUpload
        ]);
        return redirect()->to('/admin/Team')->with('msg', 'success');
    }
    public function update()
    {
        if (!$this->validate([
            'nama' => [
                'rules' => 'required|alpha_space',
                'errors' => [
                    'required' => 'Kolom {field} harus diisi!',
                    'alpha_space' => 'inputan tidak boleh mengandung karakter aneh'
                ]
            ],
            'jabatan' => [
                'rules' => 'required|alpha_space',
                'errors' => [
                    'required' => 'Kolom {field} harus diisi!',
                    'alpha_space' => 'inputan tidak boleh mengandung karakter aneh'
                ]
            ],
            'twitter' => [
                'rules' => 'required|valid_url_strict',
                'errors' => [
                    'required' => 'Kolom {field} harus diisi!',
                    'valid_url_strict' => 'Inputan harus berformat url'
                ]
            ],
            'facebook' => [
                'rules' => 'required|valid_url_strict',
                'errors' => [
                    'required' => 'Kolom {field} harus diisi!',
                    'valid_url_strict' => 'Inputan harus berformat url'
                ]
            ],
            'instagram' => [
                'rules' => 'required|valid_url_strict',
                'errors' => [
                    'required' => 'Kolom {field} harus diisi!',
                    'valid_url_strict' => 'Inputan harus berformat url'
                ]
            ],
            'linked' => [
                'rules' => 'required|valid_url_strict',
                'errors' => [
                    'required' => 'Kolom {field} harus diisi!',
                    'valid_url_strict' => 'Inputan harus berformat url'
                ]
            ],
            'filefoto' => [
                'rules' => 'max_size[filefoto,2048]|is_image[filefoto]|mime_in[filefoto,image/jpg,image/jpeg,image/png]',
                'errors' => [
                    'max_size' => 'Ukuran gambar tidak boleh lebih dari 2MB',
                    'is_image' => 'Yang anda pilih bukan gambar',
                    'mime_in' => 'Yang anda pilih bukan gambar'
                ]
            ]
        ])) {
            return redirect()->to('/admin/Team')->with('msg', 'error');
        }
        $Team_id = strip_tags(htmlspecialchars($this->request->getPost('Team_id'), ENT_QUOTES));
        $nama = strip_tags(htmlspecialchars($this->request->getPost('nama'), ENT_QUOTES));
        $jabatan = strip_tags(htmlspecialchars($this->request->getPost('jabatan'), ENT_QUOTES));
        $twitter = strip_tags(htmlspecialchars($this->request->getPost('twitter'), ENT_QUOTES));
        $facebook = strip_tags(htmlspecialchars($this->request->getPost('facebook'), ENT_QUOTES));
        $instagram = strip_tags(htmlspecialchars($this->request->getPost('instagram'), ENT_QUOTES));
        $linked = strip_tags(htmlspecialchars($this->request->getPost('linked'), ENT_QUOTES));
        // Cek Foto
        $Team = $this->TeamModel->find($Team_id);
        $fotoAwal = $Team['Team_image'];
        $fileFoto = $this->request->getFile('filefoto');
        if ($fileFoto->getName() == '') {
            $namaFotoUpload = $fotoAwal;
        } else {
            $namaFotoUpload = $fileFoto->getRandomName();
            $fileFoto->move('assets/backend/images/Team/', $namaFotoUpload);
        }
        // Simpan ke database
        $this->TeamModel->update($Team_id, [
            'Team_name' => $nama,
            'Team_jabatan' => $jabatan,
            'Team_twitter' => $twitter,
            'Team_facebook' => $facebook,
            'Team_instagram' => $instagram,
            'Team_linked' => $linked,
            'Team_image' => $namaFotoUpload
        ]);
        return redirect()->to('/admin/Team')->with('msg', 'info');
    }
    public function delete()
    {
        $Team_id = $this->request->getPost('kode');
        $this->TeamModel->delete($Team_id);
        return redirect()->to('/admin/Team')->with('msg', 'success-delete');
    }
}
