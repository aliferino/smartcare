# SmartCare - Fundraising & Donation Platform 🏥

**SmartCare** adalah solusi ekosistem digital untuk pengelolaan donasi dan penggalangan dana yang mengedepankan transparansi serta keamanan melalui proses verifikasi entitas yang ketat. Proyek ini dibangun untuk menjembatani donatur dengan lembaga penggalang dana (fundraiser) yang terpercaya.

## 🚀 Fitur Utama

### 1. Manajemen Entitas (Fundraiser)
*   **KYC Verification**: Proses pendaftaran entitas dilengkapi dengan pengunggahan dokumen legal untuk divalidasi oleh administrator.
*   **Entity Status Workflow**: Alur status entitas yang terbagi menjadi `Pending`, `Approved`, dan `Rejected` untuk kontrol kualitas fundraiser.
*   **Visibility Control**: Admin memiliki wewenang untuk mengatur visibilitas entitas (`is_active`) di dashboard publik meskipun entitas tersebut sudah diverifikasi.

### 2. Dashboard Admin & Back-Office
*   **Search & Filter Kilat**: Fitur pencarian nama (Enter-to-search) dan filter kategori yang responsif menggunakan AJAX tanpa perlu memuat ulang halaman.
*   **Activity Monitoring**: Menampilkan list entitas terbaru berdasarkan tanggal pembaruan terakhir (`updated_at`) pada halaman utama.
*   **Modern Modal System**: Detail entitas yang lengkap dengan preview dokumen legal, riwayat verifikasi, dan alasan penolakan yang tertata rapi.

### 3. Campaign & Donasi
*   **Fundraising Goals**: Pelacakan target dana (`current_amount`) dan jumlah donatur (`donors_count`) secara real-time.
*   **Anonymous Giving**: Dukungan fitur donatur anonim untuk menjaga privasi penyumbang.
*   **Invite System**: Fitur penambahan fundraiser ke dalam entity atau campaign melalui sistem undangan.

---

## 🛠️ Tech Stack
*   **Framework**: Laravel 11 (PHP 8.x)
*   **Database**: MySQL / MariaDB
*   **Frontend**: Tailwind CSS, Blade Templates, jQuery (AJAX)
*   **Typography**: Poppins (Google Fonts)
*   **Diagramming**: Mermaid & PlantUML (Model Diagram & Database Schema)

---

## 🔧 Instalasi

1. **Clone Repository**
   ```bash
   git clone [https://github.com/username/smartcare.git](https://github.com/username/smartcare.git)
   cd smartcare