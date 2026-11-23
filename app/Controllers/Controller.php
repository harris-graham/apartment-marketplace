<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ProvinceModel;
use App\Models\OfficeModel;
use App\Models\SiteModel;
use App\Models\ApartmentModel;
use App\Models\CustomerModel;
use App\Models\OfficerModel;
use App\Models\SaleModel;

class Controller extends BaseController
{
    public function loginView()
    {
        return view('LoginView');
    }

    public function login()
    {
        $session = session();
        $officer = new OfficerModel();
        $data = $officer->where('OfficerUName', $this->request->getVar('officeruname'))->first();
        if ($data) {
            $pass = $data['OfficerPword'];
            $authPword = password_verify($this->request->getVar('officerpword'), $pass);
            if ($authPword) {
                $sesData = [
                    'OfficerID' => $data['OfficerID'],
                    'OfficerName' => $data['OfficerName'],
                    'OfficerUName' => $data['OfficerUName'],
                    'isLoggedIn' => TRUE
                ];
                $session->set($sesData);
                return redirect()->to(base_url('apartSelect'));
            } else {
                $session->setFlashdata("msg", "Le mot de passe est incorrect!");
                return redirect()->to(base_url('loginView'));
            }
        } else {
            $session->setFlashdata("msg", "Le nom d'utilisateur n'existe pas!");
            return redirect()->to(base_url('loginView'));
        }
    }

    public function logout()
    {
        $session = session();
        $sesData = ['OfficerID', 'OfficerName', 'OfficerUName', 'isLoggedIn'];
        $session->remove($sesData);
        return redirect()->to(base_url('loginView'));
    }

    public function saleSelect()
    {
        $session = session();
        if ($session->get('OfficerName') != 'Admin') {
            return redirect()->to(base_url('apartSelect'));
        }
        $data['officerid'] = $session->get('OfficerID');
        $data['officername'] = $session->get('OfficerName');
        $data['officeruname'] = $session->get('OfficerUName');
        $sale = new SaleModel();
        $data['sale'] = $sale
            ->join('apartment', 'sale.ApartID = apartment.ApartID', 'left')
            ->join('customer', 'sale.CustID = customer.CustID', 'left')
            ->join('officer', 'sale.OfficerID = officer.OfficerID', 'left')
            ->join('site', 'apartment.SiteID = site.SiteID', 'left')
            ->join('office', 'site.OfficeID = office.OfficeID', 'left')
            ->join('province', 'office.ProvinceID = province.ProvinceID', 'left')
            ->orderBy('SaleDate', 'DESC')->paginate(10);
        $data['pager'] = \Config\Services::pager();
        return view('SaleView', $data);
    }

    public function saleInsert($apartid)
    {
        $sale = new SaleModel();
        $apart = new ApartmentModel();
        if (!$sale->validate($this->request->getPost())) {
            $session = session();
            $session->setFlashdata('msg', implode(', ', $sale->errors()));
            return redirect()->to(base_url('apartSelect'));
        }
        $apartment = $apart->find($apartid);
        if (!$apartment || $apartment['ApartStatus'] !== 'available') {
            $session = session();
            $session->setFlashdata('msg', 'Ce logement n\'est pas disponible à la vente.');
            return redirect()->to(base_url('apartSelect'));
        }
        $data = [
            'SaleTotal' => $this->request->getPost('saletotal'),
            'SaleType'  => $this->request->getPost('saletype'),
            'SaleDate'  => date('Y-m-d H:i:s'),
            'ApartID'   => $apartid,
            'CustID'    => $this->request->getPost('custid'),
            'OfficerID' => $this->request->getPost('officerid'),
        ];
        $sale->save($data);
        $apart->update($apartid, [
            'ApartStatus' => 'sold',
            'CustID'      => $this->request->getPost('custid'),
        ]);
        $session = session();
        $session->setFlashdata('msg', 'Vente enregistrée avec succès.');
        return redirect()->to(base_url('apartSelect'));
    }

    public function provinceInsert()
    {
        $province = new ProvinceModel();
        if (!$province->validate($this->request->getPost())) {
            $session = session();
            $session->setFlashdata('msg', implode(', ', $province->errors()));
            return redirect()->to(base_url('officeSelect'));
        }
        $data = [
            'ProvinceName' => $this->request->getPost('provincename')
        ];
        $province->save($data);
        $session = session();
        $session->setFlashdata('msg', 'Province ajoutée avec succès.');
        return redirect()->to(base_url('officeSelect'));
    }

    public function provinceUpdate($proid)
    {
        $province = new ProvinceModel();
        if (!$province->validate($this->request->getPost())) {
            $session = session();
            $session->setFlashdata('msg', implode(', ', $province->errors()));
            return redirect()->to(base_url('officeSelect'));
        }
        $data = [
            'ProvinceName' => $this->request->getPost('provincename')
        ];
        $province->update($proid, $data);
        $session = session();
        $session->setFlashdata('msg', 'Province modifiée avec succès.');
        return redirect()->to(base_url('officeSelect'));
    }

    public function provinceDelete($proid)
    {
        $province = new ProvinceModel();
        $province->delete($proid);
        $session = session();
        $session->setFlashdata('msg', 'Province supprimée avec succès.');
        return redirect()->to(base_url('officeSelect'));
    }

    public function officeSelect()
    {
        $session = session();
        $data['officerid'] = $session->get('OfficerID');
        $data['officername'] = $session->get('OfficerName');
        $data['officeruname'] = $session->get('OfficerUName');
        $office = new OfficeModel();
        $province = new ProvinceModel();
        $data['office'] = $office
            ->join('province', 'office.ProvinceID = province.ProvinceID', 'left')->paginate(10);
        $data['pager'] = \Config\Services::pager();
        $data['province'] = $province->findAll();
        return view('OfficeView', $data);
    }

    public function officeInsert()
    {
        $office = new OfficeModel();
        if (!$office->validate($this->request->getPost())) {
            $session = session();
            $session->setFlashdata('msg', implode(', ', $office->errors()));
            return redirect()->to(base_url('officeSelect'));
        }
        $data = [
            'OfficeName' => $this->request->getPost('officename'),
            'OfficeAddress' => $this->request->getPost('officeaddress'),
            'ProvinceID' => $this->request->getPost('provinceid')
        ];
        $office->save($data);
        $session = session();
        $session->setFlashdata('msg', 'Agence ajoutée avec succès.');
        return redirect()->to(base_url('officeSelect'));
    }

    public function officeUpdate($offid)
    {
        $office = new OfficeModel();
        if (!$office->validate($this->request->getPost())) {
            $session = session();
            $session->setFlashdata('msg', implode(', ', $office->errors()));
            return redirect()->to(base_url('officeSelect'));
        }
        $data = [
            'OfficeName' => $this->request->getPost('officename'),
            'OfficeAddress' => $this->request->getPost('officeaddress'),
            'ProvinceID' => $this->request->getPost('provinceid')
        ];
        $office->update($offid, $data);
        $session = session();
        $session->setFlashdata('msg', 'Agence modifiée avec succès.');
        return redirect()->to(base_url('officeSelect'));
    }

    public function officeDelete($offid)
    {
        $office = new OfficeModel();
        $office->delete($offid);
        $session = session();
        $session->setFlashdata('msg', 'Agence supprimée avec succès.');
        return redirect()->to(base_url('officeSelect'));
    }

    public function siteSelect()
    {
        $session = session();
        $data['officerid'] = $session->get('OfficerID');
        $data['officername'] = $session->get('OfficerName');
        $data['officeruname'] = $session->get('OfficerUName');
        $site = new SiteModel();
        $office = new OfficeModel();
        $data['site'] = $site
            ->join('office', 'site.OfficeID = office.OfficeID', 'left')->paginate(10);
        $data['pager'] = \Config\Services::pager();
        $data['office'] = $office->findAll();
        return view('SiteView', $data);
    }

    public function siteInsert()
    {
        $site = new SiteModel();
        if (!$site->validate($this->request->getPost())) {
            $session = session();
            $session->setFlashdata('msg', implode(', ', $site->errors()));
            return redirect()->to(base_url('siteSelect'));
        }
        $data = [
            'SiteLocation' => $this->request->getPost('sitelocation'),
            'SiteArea' => $this->request->getPost('sitearea'),
            'OfficeID' => $this->request->getPost('officeid')
        ];
        $site->save($data);
        $session = session();
        $session->setFlashdata('msg', 'Terrain ajouté avec succès.');
        return redirect()->to(base_url('siteSelect'));
    }

    public function siteUpdate($siteid)
    {
        $site = new SiteModel();
        if (!$site->validate($this->request->getPost())) {
            $session = session();
            $session->setFlashdata('msg', implode(', ', $site->errors()));
            return redirect()->to(base_url('siteSelect'));
        }
        $data = [
            'SiteLocation' => $this->request->getPost('sitelocation'),
            'SiteArea' => $this->request->getPost('sitearea'),
            'OfficeID' => $this->request->getPost('officeid')
        ];
        $site->update($siteid, $data);
        $session = session();
        $session->setFlashdata('msg', 'Terrain modifié avec succès.');
        return redirect()->to(base_url('siteSelect'));
    }

    public function siteDelete($siteid)
    {
        $site = new SiteModel();
        $site->delete($siteid);
        $session = session();
        $session->setFlashdata('msg', 'Terrain supprimé avec succès.');
        return redirect()->to(base_url('siteSelect'));
    }

    public function apartSelect()
    {
        $session = session();
        $data['officerid'] = $session->get('OfficerID');
        $data['officername'] = $session->get('OfficerName');
        $data['officeruname'] = $session->get('OfficerUName');
        $apart = new ApartmentModel();
        $site = new SiteModel();
        $cust = new CustomerModel();
        $province = new ProvinceModel();
        $office = new OfficeModel();

        $status = $this->request->getGet('status');
        $siteid = $this->request->getGet('siteid');
        $priceMin = $this->request->getGet('priceMin');
        $priceMax = $this->request->getGet('priceMax');

        $builder = $apart->join('site', 'apartment.SiteID = site.SiteID', 'left')
            ->join('customer', 'apartment.CustID = customer.CustID', 'left')
            ->join('office', 'site.OfficeID = office.OfficeID', 'left')
            ->join('province', 'office.ProvinceID = province.ProvinceID', 'left');
        if ($status !== null && $status !== '') {
            $builder->where('apartment.ApartStatus', $status);
        }
        if ($siteid !== null && $siteid !== '') {
            $builder->where('apartment.SiteID', $siteid);
        }
        if ($priceMin !== null && $priceMin !== '') {
            $builder->where('apartment.ApartPrice >=', $priceMin);
        }
        if ($priceMax !== null && $priceMax !== '') {
            $builder->where('apartment.ApartPrice <=', $priceMax);
        }
        $data['apart'] = $builder->orderBy('apartment.ApartID', 'DESC')->paginate(10);
        $pager = \Config\Services::pager();
        $data['pager'] = $pager;
        $data['site'] = $site->findAll();
        $data['cust'] = $cust->findAll();
        $data['status'] = $status;
        $data['siteid'] = $siteid;
        $data['priceMin'] = $priceMin;
        $data['priceMax'] = $priceMax;
        return view('ApartmentView', $data);
    }

    public function apartInsert()
    {
        helper(['form', 'url']);
        $apart = new ApartmentModel();
        if (!$apart->validate($this->request->getPost())) {
            $session = session();
            $session->setFlashdata('msg', implode(', ', $apart->errors()));
            return redirect()->to(base_url('apartSelect'));
        }
        $apartimg = null;
        if ($this->request->getFile('apartimg')->getName() != null) {
            $this->request->getFile('apartimg')->move(WRITEPATH . 'uploads', null, true);
            $apartimg = base64_encode(file_get_contents(WRITEPATH . 'uploads\\' . $this->request->getFile('apartimg')->getName()));
        }
        $data = [
            'ApartAddress' => $this->request->getPost('apartaddress'),
            'ApartPrice' => $this->request->getPost('apartprice'),
            'SiteID' => $this->request->getPost('siteid'),
            'ApartStatus' => 'available',
        ];
        if ($apartimg != null) {
            $data['ApartImg'] = $apartimg;
        }
        $apart->save($data);
        $session = session();
        $session->setFlashdata('msg', 'Logement ajouté avec succès.');
        return redirect()->to(base_url('apartSelect'));
    }

    public function apartUpdate($apartid)
    {
        helper(['form', 'url']);
        $apart = new ApartmentModel();
        if (!$apart->validate($this->request->getPost())) {
            $session = session();
            $session->setFlashdata('msg', implode(', ', $apart->errors()));
            return redirect()->to(base_url('apartSelect'));
        }
        $data = [
            'ApartAddress' => $this->request->getPost('apartaddress'),
            'ApartPrice' => $this->request->getPost('apartprice'),
            'SiteID' => $this->request->getPost('siteid')
        ];
        if ($this->request->getFile('apartimg')->getName() != null) {
            $this->request->getFile('apartimg')->move(WRITEPATH . 'uploads', null, true);
            $apartimg = base64_encode(file_get_contents(WRITEPATH . 'uploads\\' . $this->request->getFile('apartimg')->getName()));
            $data['ApartImg'] = $apartimg;
        }
        $apart->update($apartid, $data);
        $session = session();
        $session->setFlashdata('msg', 'Logement modifié avec succès.');
        return redirect()->to(base_url('apartSelect'));
    }

    public function apartDelete($apartid)
    {
        $apart = new ApartmentModel();
        $apart->delete($apartid);
        return redirect()->to(base_url('apartSelect'));
    }

    public function custSelect()
    {
        $session = session();
        $data['officerid'] = $session->get('OfficerID');
        $data['officername'] = $session->get('OfficerName');
        $data['officeruname'] = $session->get('OfficerUName');
        $cust = new CustomerModel();
        $apart = new ApartmentModel();
        $data['cust'] = $cust->paginate(10);
        $data['pager'] = \Config\Services::pager();
        $data['apart'] = $apart
            ->join('customer', 'apartment.CustID = customer.CustID', 'left')->findAll();
        return view('CustomerView', $data);
    }

    public function custInsert()
    {
        $cust = new CustomerModel();
        if (!$cust->validate($this->request->getPost())) {
            $session = session();
            $session->setFlashdata('msg', implode(', ', $cust->errors()));
            return redirect()->to(base_url('custSelect'));
        }
        $data = [
            'CustName' => $this->request->getPost('custname'),
            'CustPNum' => $this->request->getPost('custpnum'),
            'CustAddress' => $this->request->getPost('custaddress')
        ];
        $cust->save($data);
        $session = session();
        $session->setFlashdata('msg', 'Client ajouté avec succès.');
        return redirect()->to(base_url('custSelect'));
    }

    public function custQuiInsert()
    {
        $cust = new CustomerModel();
        if (!$cust->validate($this->request->getPost())) {
            $session = session();
            $session->setFlashdata('msg', implode(', ', $cust->errors()));
            return redirect()->to(base_url('apartSelect'));
        }
        $data = [
            'CustName' => $this->request->getPost('custname'),
            'CustPNum' => $this->request->getPost('custpnum'),
            'CustAddress' => $this->request->getPost('custaddress')
        ];
        $cust->save($data);
        $session = session();
        $session->setFlashdata('msg', 'Client ajouté avec succès.');
        return redirect()->to(base_url('apartSelect'));
    }

    public function custUpdate($custid)
    {
        $cust = new CustomerModel();
        if (!$cust->validate($this->request->getPost())) {
            $session = session();
            $session->setFlashdata('msg', implode(', ', $cust->errors()));
            return redirect()->to(base_url('custSelect'));
        }
        $data = [
            'CustName' => $this->request->getPost('custname'),
            'CustPNum' => $this->request->getPost('custpnum'),
            'CustAddress' => $this->request->getPost('custaddress')
        ];
        $cust->update($custid, $data);
        $session = session();
        $session->setFlashdata('msg', 'Client modifié avec succès.');
        return redirect()->to(base_url('custSelect'));
    }

    public function custDelete($custid)
    {
        $cust = new CustomerModel();
        $cust->delete($custid);
        $session = session();
        $session->setFlashdata('msg', 'Client supprimé avec succès.');
        return redirect()->to(base_url('custSelect'));
    }

    public function officerSelect()
    {
        $session = session();
        if ($session->get('OfficerName') != 'Admin') {
            return redirect()->to(base_url('apartSelect'));
        }
        $data['officerid'] = $session->get('OfficerID');
        $data['officername'] = $session->get('OfficerName');
        $data['officeruname'] = $session->get('OfficerUName');
        $officer = new OfficerModel();
        $data['officer'] = $officer
            ->select('officer.*, COUNT(CustID) AS SaleNb')
            ->join('sale', 'officer.OfficerID = sale.OfficerID', 'left')
            ->groupBy('officer.OfficerID')
            ->orderBy('SaleNb', 'DESC')
            ->where("OfficerName != 'Admin'")->paginate(10);
        $data['pager'] = \Config\Services::pager();
        return view('OfficerView', $data);
    }

    public function officerInsert()
    {
        $officer = new OfficerModel();
        if (!$officer->validate($this->request->getVar())) {
            $session = session();
            $session->setFlashdata('msg', implode(', ', $officer->errors()));
            return redirect()->to(base_url('officerSelect'));
        }
        $data = [
            'OfficerName' => $this->request->getVar('officername'),
            'OfficerPNum' => $this->request->getVar('officerpnum'),
            'OfficerAddress' => $this->request->getVar('officeraddress'),
            'OfficerUName' => $this->request->getVar('officeruname'),
            'OfficerPword' => password_hash($this->request->getVar('officerpword'), PASSWORD_DEFAULT),
            'OfficerRole' => $this->request->getVar('officerrole') ?? 'agent',
        ];
        $officer->save($data);
        $session = session();
        $session->setFlashdata('msg', 'Agent ajouté avec succès.');
        return redirect()->to(base_url('officerSelect'));
    }

    public function officerUpdate($officerid)
    {
        $officer = new OfficerModel();
        $rules = [
            'OfficerName' => 'required|max_length[60]',
            'OfficerUName' => 'required|max_length[20]|is_unique[officer.OfficerUName,id,' . $officerid . ']',
        ];
        if (!$officer->validate($this->request->getVar(), $rules)) {
            $session = session();
            $session->setFlashdata('msg', implode(', ', $officer->errors()));
            return redirect()->to(base_url('officerSelect'));
        }
        $data = [
            'OfficerName' => $this->request->getVar('officername'),
            'OfficerPNum' => $this->request->getVar('officerpnum'),
            'OfficerAddress' => $this->request->getVar('officeraddress'),
            'OfficerUName' => $this->request->getVar('officeruname')
        ];
        if ($this->request->getVar('officerpword') != null) {
            $data['OfficerPword'] = password_hash($this->request->getVar('officerpword'), PASSWORD_DEFAULT);
        }
        $officer->update($officerid, $data);
        $session = session();
        $session->setFlashdata('msg', 'Agent modifié avec succès.');
        return redirect()->to(base_url('officerSelect'));
    }

    public function officerAccUpdate($officerid)
    {
        $officer = new OfficerModel();
        $rules = [
            'OfficerUName' => 'required|max_length[20]|is_unique[officer.OfficerUName,id,' . $officerid . ']',
        ];
        if (!$officer->validate($this->request->getVar(), $rules)) {
            $session = session();
            $session->setFlashdata('msg', implode(', ', $officer->errors()));
            return redirect()->to(base_url('apartSelect'));
        }
        $data = [
            'OfficerUName' => $this->request->getVar('officeruname')
        ];
        if ($this->request->getVar('officerpword') != null) {
            $data['OfficerPword'] = password_hash($this->request->getVar('officerpword'), PASSWORD_DEFAULT);
        }
        $officer->update($officerid, $data);
        $session = session();
        $session->setFlashdata('msg', 'Compte modifié avec succès.');
        return redirect()->to(base_url('apartSelect'));
    }

    public function officerDelete($officerid)
    {
        $officer = new OfficerModel();
        $officer->delete($officerid);
        $session = session();
        $session->setFlashdata('msg', 'Agent supprimé avec succès.');
        return redirect()->to(base_url('officerSelect'));
    }

    public function dashboard()
    {
        $session = session();
        $data['officerid'] = $session->get('OfficerID');
        $data['officername'] = $session->get('OfficerName');
        $data['officeruname'] = $session->get('OfficerUName');
        $apart = new ApartmentModel();
        $sale = new SaleModel();
        $officer = new OfficerModel();
        $data['totalApart'] = $apart->countAllResults();
        $data['soldApart'] = $apart->where('ApartStatus', 'sold')->countAllResults(false);
        $data['availableApart'] = $apart->where('ApartStatus', 'available')->countAllResults(false);
        $data['totalSales'] = $sale->countAllResults();
        $revenueRow = $sale->select('SUM(SaleTotal) AS total')->get()->getRow();
        $data['revenue'] = $revenueRow ? $revenueRow->total : 0;
        $data['topOfficer'] = $officer
            ->select('officer.*, COUNT(sale.SaleID) AS SaleNb')
            ->join('sale', 'officer.OfficerID = sale.OfficerID', 'left')
            ->groupBy('officer.OfficerID')
            ->orderBy('SaleNb', 'DESC')
            ->limit(1)->first();
        return view('DashboardView', $data);
    }

    public function saleExport()
    {
        $session = session();
        if ($session->get('OfficerName') != 'Admin') {
            return redirect()->to(base_url('apartSelect'));
        }
        $sale = new SaleModel();
        $sales = $sale
            ->join('apartment', 'sale.ApartID = apartment.ApartID', 'left')
            ->join('customer', 'sale.CustID = customer.CustID', 'left')
            ->join('officer', 'sale.OfficerID = officer.OfficerID', 'left')
            ->orderBy('SaleDate', 'DESC')->findAll();

        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename=sales_export.csv');
        $output = fopen('php://output', 'w');
        fputcsv($output, ['SaleID', 'SaleDate', 'Logement', 'Prix', 'Client', 'Type', 'Agent']);
        foreach ($sales as $row) {
            fputcsv($output, [
                $row['SaleID'],
                $row['SaleDate'],
                $row['ApartAddress'] ?? '',
                $row['SaleTotal'],
                $row['CustName'] ?? '',
                $row['SaleType'],
                $row['OfficerName'] ?? '',
            ]);
        }
        fclose($output);
        exit;
    }
}
