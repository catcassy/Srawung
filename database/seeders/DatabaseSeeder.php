<?php
namespace Database\Seeders;

use App\Models\User;
use App\Models\Post;
use App\Models\Comment;
use App\Models\Location;
use App\Models\Follow;
use App\Models\Like;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $users = [];
        $data  = [
            ['Budi Santoso',  'budi_s',   'publik'],
            ['Siti Aminah',   'siti_a',   'publik'],
            ['Rina Kusuma',   'rina_k',   'publik'],
            ['Ahmad Fauzi',   'ahmad_f',  'anonim'],
        ];

        foreach ($data as [$name, $uname, $mode]) {
            $users[] = User::create([
                'name'     => $name,
                'username' => $uname,
                'email'    => "$uname@demo.com",
                'password' => Hash::make('password'),
                'mode'     => $mode,
                'bio'      => 'Warga Jember yang suka berbagi 😊',
                'kota'     => 'Jember',
                'latitude' => -8.1653 + (rand(-10,10)/1000),
                'longitude'=> 113.7159 + (rand(-10,10)/1000),
            ]);
        }

        // Follow satu sama lain
        Follow::create(['follower_id'=>$users[0]->id,'following_id'=>$users[1]->id]);
        Follow::create(['follower_id'=>$users[1]->id,'following_id'=>$users[0]->id]);
        Follow::create(['follower_id'=>$users[2]->id,'following_id'=>$users[0]->id]);

        // Posts
        $posts = [
            ['Halo Jember! Selamat datang di Srawung 🙌 Platform komunitas lokal buat kita saling berbagi cerita dan rekomendasi.', 'publik', 0],
            ['Kemarin nyobain kopi susu di kawasan Patrang, enak banget dan harganya terjangkau. Ada yang sudah pernah ke sana? ☕', 'publik', 1],
            ['Info: ada pembukaan jalan baru di area Kaliwates mulai pekan depan. Hati-hati yang lewat sana ya!', 'anonim', 3],
            ['Rekomendasi tempat buat nugas yang adem di Jember? Perpustakaan daerah oke tapi kadang penuh 😅', 'publik', 2],
            ['Ada yang tahu bengkel motor jujur di sekitar Jember? Banyak yang nakal soalnya 😅', 'anonim', 3],
        ];

        foreach ($posts as [$content, $mode, $ui]) {
            $post = Post::create([
                'user_id'   => $users[$ui]->id,
                'content'   => $content,
                'mode_post' => $mode,
            ]);
            // Komentar
            Comment::create([
                'post_id' => $post->id,
                'user_id' => $users[($ui+1)%4]->id,
                'body'    => 'Wah makasih infonya! 👍',
            ]);
            // Like
            Like::create(['post_id' => $post->id, 'user_id' => $users[($ui+2)%4]->id]);
        }

        // Thread Lokal
        Post::create([
            'user_id'         => $users[0]->id,
            'content'         => '📍 Thread Lokal Kaliwates: Pasar pagi di ujung Jl. Veteran buka jam 5, sayurannya segar banget! Lebih murah dari supermarket.',
            'mode_post'       => 'publik',
            'is_local_thread' => true,
            'area_label'      => 'Kaliwates',
            'latitude'        => -8.1653,
            'longitude'       => 113.7159,
            'radius_km'       => 5,
        ]);

        // Lokasi
        foreach ([
            ['Warung Pecel Bu Ningsih', 'Jl. Gatot Subroto No. 12, Jember', 'kuliner', 'Pecel legendaris sejak 1985. Buka jam 6 pagi, porsi besar, harga mahasiswa!', 0],
            ['Kebun Raya Jember',       'Jl. Kalimantan, Jember',           'wisata',  'Tempat asri buat jogging, piknik, dan healing. Tiket sangat terjangkau.',     1],
            ['Perpustakaan Daerah',     'Jl. Sriwijaya No. 1, Jember',      'pendidikan','Koleksi lengkap, AC sejuk, wifi gratis. Pinjam buku gratis dengan KTP.',   2],
        ] as [$nama, $alamat, $kat, $desk, $ui]) {
            Location::create([
                'user_id'   => $users[$ui]->id,
                'nama'      => $nama,
                'alamat'    => $alamat,
                'kategori'  => $kat,
                'deskripsi' => $desk,
            ]);
        }

        $this->command->info('✅ Seeder selesai!');
        $this->command->info('Login: budi_s@demo.com / password');
    }
}
