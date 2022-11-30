<?php


class Dashboard_model extends CI_model
{
    public function count()
    {
        $this->db->select("(SELECT COUNT(kr.karyawan_id) FROM tbl_karyawan kr) as karyawancount");
        $this->db->select("(SELECT COUNT(hd.hadir_id) FROM tbl_hadir hd) as hadircount");
        $this->db->select("(SELECT COUNT(pz.perijinan_id) FROM tbl_perijinan pz) as ijincount");
        $this->db->select("(SELECT COUNT(pl.pulang_id) FROM tbl_pulang pl) as pulangcount");
        $this->db->select("(SELECT COUNT(sk.sakit_id) FROM tbl_sakit sk) as sakitcount");
        $this->db->select("(SELECT COUNT(us.id) FROM tbl_user us) as usercount");
        return $this->db->get();
    }
}
