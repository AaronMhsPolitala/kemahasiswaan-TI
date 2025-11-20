<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Models\Pendaftaran;

class JabatanRule implements Rule
{
    protected $divisiId;
    protected $jabatan;
    protected $pendaftaranId;

    public function __construct($divisiId, $jabatan, $pendaftaranId = null)
    {
        $this->divisiId = $divisiId;
        $this->jabatan = $jabatan;
        $this->pendaftaranId = $pendaftaranId;
    }

    public function passes($attribute, $value)
    {
        if ($this->jabatan === 'Anggota Divisi') {
            return true;
        }

        $query = Pendaftaran::where('divisi_id', $this->divisiId)
            ->where('jabatan', $this->jabatan);

        if ($this->pendaftaranId) {
            $query->where('id', '!=', $this->pendaftaranId);
        }

        $count = $query->count();

        if ($this->jabatan === 'Ketua Koordinator' || $this->jabatan === 'Wakil Koordinator') {
            return $count === 0;
        }

        return true;
    }

    public function message()
    {
        return 'Maaf, jabatan wakil atau ketua sudah terisi.';
    }
}
