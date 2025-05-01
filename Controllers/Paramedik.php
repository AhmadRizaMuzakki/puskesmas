<?php
require_once 'Config/DB.php';

class Paramedik
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function index()
    {
        $stmt = $this->pdo->query("SELECT * FROM paramedik");

        return $stmt->fetchAll();
    }
    
    public function show()
    {
        $stmt = $this->pdo->prepare("
            SELECT 
                paramedik.*,
                unit_kerja.nama AS kantor
            FROM paramedik
            INNER JOIN unit_kerja ON paramedik.unit_kerja_id = unit_kerja.id
        ");
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function create($data)
    {
        $stmt = $this->pdo->prepare("INSERT INTO paramedik (nama, gender, tmp_lahir, tgl_lahir, kategori, telpon, alamat, unit_kerja_id) VALUES (?,?,?,?,?,?,?,?)");
        return $stmt->execute([$data['nama'], $data['gender'], $data['tmp_lahir'], $data['tgl_lahir'], $data['kategori'], $data['telpon'], $data['alamat'], $data['unit_kerja_id']]);
    }

    public function update($id, $data)
    {
        $stmt = $this->pdo->prepare("UPDATE paramedik SET nama = ?, gender = ?, tmp_lahir = ?, tgl_lahir = ?, kategori = ?, telpon = ?, alamat = ?, unit_kerja_id = ? WHERE id = ?");
        return $stmt->execute([$data['nama'], $data['gender'], $data['tmp_lahir'], $data['tgl_lahir'], $data['kategori'], $data['telpon'], $data['alamat'], $data['unit_kerja_id'], $id]);
    }

    public function delete($id)
    {
        $stmt = $this->pdo->prepare("DELETE FROM paramedik WHERE id = ?");
        return $stmt->execute([$id]);
    }
}

$paramedik = new Paramedik($pdo);
