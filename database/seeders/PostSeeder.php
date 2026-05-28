<?php

namespace Database\Seeders;

use App\Models\Post;
use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * 
     * Membuat data dummy hoaks & fakta untuk feed media sosial
     */
    public function run(): void
    {
        $posts = [
            [
                'type' => 'hoaks',
                'title' => 'Minum Air Es Setelah Makan Berminyak Bisa Bikin Kanker',
                'content' => 'Peringatan! Minum air es setelah makan makanan berminyak dapat membekukan lemak di usus dan menyebabkan kanker. Hindari minum es setelah makan!',
                'image' => null,
                'source' => 'Forwarded Message',
                'explanation' => 'INI HOAKS! Tidak ada bukti ilmiah bahwa air es membekukan lemak di usus. Asam lambung kita memiliki suhu yang bisa merespons perubahan suhu makanan/minuman. Lemak dicerna oleh enzim, bukan dibekukan.',
                'likes' => 1250,
                'shares' => 890,
            ],
            [
                'type' => 'fakta',
                'title' => 'Cara Cek Berita Hoaks dari Logo Media',
                'content' => 'Tips mengenali hoaks: Cek apakah ada logo media terpercaya, apakah domain website sesuai (misal: kompas.com bukan kompas123.com), dan apakah ada nama penulis yang jelas.',
                'image' => null,
                'source' => 'Kompas.com',
                'explanation' => 'INI FAKTA! Memeriksa sumber berita adalah langkah penting. Media terpercaya selalu mencantumkan logo, domain resmi, dan nama penulis. Website hoaks sering menggunakan domain mirip tapi tidak sama.',
                'likes' => 3420,
                'shares' => 2100,
            ],
            [
                'type' => 'hoaks',
                'title' => 'Vaksin COVID-19 Mengandung Chip Mikro untuk Melacak Orang',
                'content' => 'Terbongkar! Vaksin COVID-19 mengandung chip mikro السنαι untuk melacak gerakan penduduk. Bill Gates ingin mengendalikan populasi dunia!',
                'image' => null,
                'source' => 'WhatsApp Group',
                'explanation' => 'INI HOAKS! Vaksin COVID-19 TIDAK mengandung chip atau teknologi pelacakan. Ukurannya terlalu kecil untuk disuntikkan. Ini adalah teori konspirasi yang telah dibantah oleh banyak ahli dan organisasi kesehatan.',
                'likes' => 567,
                'shares' => 2340,
            ],
            [
                'type' => 'fakta',
                'title' => 'Literasi Digital Penting untuk Mencegah Penyebaran Hoaks',
                'content' => 'Kementerian Komunikasi dan Informatika mencatat 80% penyebaran hoaks terjadi melalui media sosial. Tingkatkan literasi digital untuk memverifikasi informasi sebelum membagikannya.',
                'image' => null,
                'source' => 'Kominfo',
                'explanation' => 'INI FAKTA! Literasi digital membantu masyarakat mengenali informasi palsu. Verifikasi sumber berita, periksa keaslian domain, dan jangan langsung membagikan informasi yang belum jelas.',
                'likes' => 2890,
                'shares' => 760,
            ],
        ];

        Post::insert($posts);
    }
}