<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Submission extends Model
{
    use HasFactory;
    protected $table = 'submissions';
    protected $primaryKey = 'id';
    protected $fillable = [
        'submission_code',
        'id_pengaju',
        'nama_mitra',
        'institusi_mitra',
        'id_pendanaan_mitra',
        'dokumen_usulan',
        'skema',
        'judul_publikasi',
        'judul_usulan',
        'riset_unggulan',
        'tema',
        'topik',
        'target_luaran',
        'target_luaran_tambahan',
        'proposal_usulan',
        'laporan_akhir',
        'laporan_final',
        'ppt_laporan',
        'luaran_publikasi',
        'nama_jurnal',
        'link_jurnal',
        'draft_artikel',
        'status_publikasi_jurnal',
        'tipe_submission',
        'spk_upload',
        'spk_download',

        'waktu_usulan',
        'status_usulan',
        'alasan_usulan_ditolak',
        'dokumen_tambahan_usulan',

        'waktu_proposal',
        'status_proposal',
        'alasan_proposal_ditolak',
        'dokumen_tambahan_proposal',

        'waktu_spk',
        'status_spk',
        'alasan_spk_ditolak',

        'waktu_laporan_akhir',
        'status_laporan_akhir',
        'alasan_laporan_akhir_ditolak',
        'dokumen_tambahan_laporan_akhir',

        'waktu_monev',
        'status_monev',
        'alasan_monev_ditolak',
        'dokumen_tambahan_monev',
        'waktu_sidang',
        'komentar_reviewer',

        'waktu_laporan_final',
        'status_laporan_final',
        'alasan_laporan_final_ditolak',
        'dokumen_tambahan_laporan_final',

        'waktu_publikasi',
        'status_publikasi',
        'alasan_publikasi_ditolak',

        'dokumen_submit',
        'tanggal_submit',
        'dokumen_revision',
        'tanggal_revision',
        'dokumen_accepted',
        'tanggal_accepted',
        'dokumen_publish',
        'tanggal_publish',
        'dokumen_rejected',
        'tanggal_rejected',

        'review_proposal_by',
        'review_laporan_akhir_by',
        'second_status',
        'status_akhir',
    ];

    public static function generateUniqueNumber()
    {
        $existingSubmissionCode = Submission::pluck('submission_code')->toArray();

        do {
            $newSubmissionCode = mt_rand(1000, 9999).'-'.mt_rand(1000, 9999).'-'.mt_rand(1000, 9999);
        } while (in_array($newSubmissionCode, $existingSubmissionCode));

        return $newSubmissionCode;
    }
}
