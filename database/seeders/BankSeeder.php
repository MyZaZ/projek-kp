<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BankSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $banks = [
            ['sandi_bank' => '002', 'nama_bank' => 'Bank BRI'],
            ['sandi_bank' => '009', 'nama_bank' => 'Bank BCA'],
            ['sandi_bank' => '014', 'nama_bank' => 'Bank Mandiri'],
            ['sandi_bank' => '011', 'nama_bank' => 'Bank CIMB Niaga'],
            ['sandi_bank' => '008', 'nama_bank' => 'Bank BNI'],
            ['sandi_bank' => '022', 'nama_bank' => 'Bank Maybank Indonesia'],
            ['sandi_bank' => '200', 'nama_bank' => 'Bank Mega'],
            ['sandi_bank' => '006', 'nama_bank' => 'Bank Rakyat Indonesia'],
            ['sandi_bank' => '213', 'nama_bank' => 'Bank Tabungan Negara'],
            ['sandi_bank' => '016', 'nama_bank' => 'Bank OCBC NISP'],
            ['sandi_bank' => '427', 'nama_bank' => 'Bank BTPN'],
            ['sandi_bank' => '426', 'nama_bank' => 'Bank Sinarmas'],
            ['sandi_bank' => '145', 'nama_bank' => 'Bank Victoria International'],
            ['sandi_bank' => '022', 'nama_bank' => 'Bank Mayapada International'],
            ['sandi_bank' => '050', 'nama_bank' => 'Bank Artha Graha Internasional'],
            ['sandi_bank' => '034', 'nama_bank' => 'Bank Negara Indonesia'],
            ['sandi_bank' => '111', 'nama_bank' => 'Bank Panin'],
            ['sandi_bank' => '213', 'nama_bank' => 'Bank Negara Indonesia Syariah'],
            ['sandi_bank' => '008', 'nama_bank' => 'Bank Mandiri Syariah'],
            ['sandi_bank' => '451', 'nama_bank' => 'Bank Bukopin Syariah'],
            ['sandi_bank' => '097', 'nama_bank' => 'Bank Muamalat'],
            ['sandi_bank' => '016', 'nama_bank' => 'Bank DKI'],
            ['sandi_bank' => '014', 'nama_bank' => 'Bank Commonwealth'],
            ['sandi_bank' => '009', 'nama_bank' => 'Bank Nusantara Parahyangan'],
            ['sandi_bank' => '113', 'nama_bank' => 'Bank Maspion'],
            ['sandi_bank' => '061', 'nama_bank' => 'Bank QNB Indonesia'],
            ['sandi_bank' => '095', 'nama_bank' => 'Bank Capital Indonesia'],
            ['sandi_bank' => '441', 'nama_bank' => 'Bank BCA Syariah'],
            ['sandi_bank' => '034', 'nama_bank' => 'Bank BNI Syariah'],
            ['sandi_bank' => '009', 'nama_bank' => 'Bank Mandiri Utama Finance'],
            ['sandi_bank' => '008', 'nama_bank' => 'Bank BNI Multifinance'],
            ['sandi_bank' => '002', 'nama_bank' => 'Bank BRI Agroniaga'],
            ['sandi_bank' => '011', 'nama_bank' => 'Bank CIMB Niaga Syariah'],
            ['sandi_bank' => '009', 'nama_bank' => 'Bank Ekonomi Raharja'],
            ['sandi_bank' => '006', 'nama_bank' => 'Bank Jasa Jakarta'],
            ['sandi_bank' => '114', 'nama_bank' => 'Bank KB Bukopin'],
            ['sandi_bank' => '116', 'nama_bank' => 'Bank Kesejahteraan Ekonomi'],
            ['sandi_bank' => '011', 'nama_bank' => 'Bank Mayora'],
            ['sandi_bank' => '013', 'nama_bank' => 'Bank Mestika Dharma'],
            ['sandi_bank' => '110', 'nama_bank' => 'Bank MNC'],
            ['sandi_bank' => '145', 'nama_bank' => 'Bank MNC Internasional'],
            ['sandi_bank' => '112', 'nama_bank' => 'Bank Nusa Tenggara'],
            ['sandi_bank' => '002', 'nama_bank' => 'Bank OCBC Indonesia'],
            ['sandi_bank' => '147', 'nama_bank' => 'Bank OCBC Sekuritas Indonesia'],
            ['sandi_bank' => '019', 'nama_bank' => 'Bank Victoria International'],
            ['sandi_bank' => '945', 'nama_bank' => 'Bank Yudha Bhakti'],
            ['sandi_bank' => '116', 'nama_bank' => 'Bank Tabungan Pensiunan Nasional'],
            ['sandi_bank' => '095', 'nama_bank' => 'Bank Syariah Mandiri'],
            ['sandi_bank' => '200', 'nama_bank' => 'Bank Central Asia Syariah'],
            ['sandi_bank' => '145', 'nama_bank' => 'Bank Maybank Syariah Indonesia'],
            ['sandi_bank' => '116', 'nama_bank' => 'Bank Negara Indonesia Syariah'],
            ['sandi_bank' => '114', 'nama_bank' => 'Bank Tabungan Negara Syariah'],
            ['sandi_bank' => '110', 'nama_bank' => 'Bank CIMB Niaga Syariah'],
            ['sandi_bank' => '028', 'nama_bank' => 'Bank Sinarmas Syariah'],
            ['sandi_bank' => '111', 'nama_bank' => 'Bank Sahabat Sampoerna'],
            ['sandi_bank' => '213', 'nama_bank' => 'Bank Sahabat Purba Danarta'],
            ['sandi_bank' => '014', 'nama_bank' => 'Bank Sahabat Purba Danarta'],
            ['sandi_bank' => '034', 'nama_bank' => 'Bank Surya'],
            ['sandi_bank' => '007', 'nama_bank' => 'Bank Tabungan Pensiunan Nasional Syariah'],
            ['sandi_bank' => '110', 'nama_bank' => 'Bank Victoria International'],
            ['sandi_bank' => '200', 'nama_bank' => 'Bank Woori Saudara Indonesia 1906'],
            // Silakan tambahkan bank lainnya sesuai kebutuhan
        ];

        // Urutkan array $banks berdasarkan nama bank secara ascending
        usort($banks, function ($a, $b) {
            return strcmp($a['nama_bank'], $b['nama_bank']);
        });

        DB::table('banks')->insert($banks);
    }
}
