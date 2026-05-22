<x-mail::message>
# Pengajuan Pemilik Kos Baru

Halo Admin,

Sistem kami mendeteksi adanya permintaan baru dari pengguna yang ingin bergabung sebagai mitra Pemilik Kos di Re-Kost.
Mohon untuk segera meninjau permohonan ini dan memeriksa kelengkapan dokumen KTP yang telah dilampirkan. 

Berikut adalah detail informasi pengguna tersebut:

- **Nama**: {{ $user->name }}
- **Email**: {{ $user->email }}

Silakan login ke panel admin untuk menyetujui atau menolak pengajuan ini.

Terima kasih,<br>
{{ config('app.name') }}
</x-mail::message>
