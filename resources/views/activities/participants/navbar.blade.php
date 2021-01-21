<nav class="navbar navbar-expand-lg navbar-light bg-light" style="background-color:transparent;">
    <a class="nav-link" href="/kegiatan/peserta/absensi/{{ $activity_item }}">Daftar Hadir</a>
    <a class="nav-link" href="/activity/{{ $activity->category->id }}/{{ $activity_item }}">Evaluasi Belajar</a>
    <a class="nav-link" href="/schedule/{{ $activity }}/{{ $activity_item }}">Jadwal</a>
    <a class="nav-link" href="/lesson/{{ $activity }}/{{ $activity_item }}">Materi</a>
    <a class="nav-link" href="/kegiatan/peserta/sertifikat/{{ $activity_item }}">Sertifikat</a>
</nav>