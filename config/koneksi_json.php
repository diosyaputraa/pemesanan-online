<?php

class JsonDB {
    private $file;

    public function __construct($file) {
        $this->file = $file;

        // 🔥 kalau file belum ada → buat otomatis
        if (!file_exists($this->file)) {
            file_put_contents($this->file, json_encode([], JSON_PRETTY_PRINT));
        }
    }

    public function getData() {
        $json = file_get_contents($this->file);

        if (!$json) {
            return [];
        }

        $data = json_decode($json, true);

        // 🔥 kalau rusak → reset
        if (!is_array($data)) {
            $data = [];
        }

        return $data;
    }

    public function addData($dataBaru) {
        $data = $this->getData();
        $data[] = $dataBaru;

        // 🔥 simpan + cek gagal
        if (!file_put_contents($this->file, json_encode($data, JSON_PRETTY_PRINT))) {
            die("❌ Gagal menyimpan ke JSON");
        }
    }
}

// 🔥 PATH FINAL (PALING PENTING)
function getJsonConnection() {
    return new JsonDB(__DIR__ . '/../data/data_pemesanan.json');
}