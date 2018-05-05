# Arisan

Arisan adalah sebuah sistem pengelolaan grup arisan berbasis web yang dibangun dengan framework Laravel 5.

## Tujuan
Arisan bertujuan untuk mempermudah pengelola arisan dalam mengatur pertemuan dan mengelola pembayaran anggota.

## Konsep

Untuk mencapai tujuan di atas, berikut adalah konsep yang akan diterapkan pada sistem ini :

- Setiap user dapat mendaftar.
- Setiap user dapat membuat grup arisan (satu atau lebih).
- Setiap grup arisan dapat diisi sejumlah anggota (user) dengan kapasitas tertentu (limit 20 anggota).
- Satu user boleh sebagai lebih dari 1 anggota di dalam satu grup.
- Setiap grup arisan ada list pertemuan sesuai jumlah anggota.
- Setiap grup ada pengaturan currency/mata uang, jumlah iuran arisan, dan kapasitas anggota.
- Setiap satu pertemuan ada tanggal, tempat, nama anggota yg dapat arisan, rekening yang dapat arisan, list pembayaran anggota.
- Pada list pembayaran ada jumlah yang dibayar, tanggal, user tujuan bayar (dibayar ke siapa), cara bayar.

Sementara itu dulu konsepnya, jika ada perkembangan, akan diupdate kembali.

## Lisensi

Project Arisan merupakan software free dan open source di bawah [lisensi MIT](LICENSE).