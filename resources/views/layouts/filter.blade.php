<div class="col-md-2">
    <div class="form-group">
        <select class="custom-select" name="dbProdi" id="dbProdi">
            <option selected="selected">Program Studi</option>
            @foreach ($dbProdi as $prodi)
                <option value="{{ $prodi->nama_prodi }}">{{ $prodi->nama_prodi }}</option>
            @endforeach
        </select>
    </div>
</div>
<div class="col-md-2">
    <div class="form-group">
        <select class="custom-select" name="dbSemester" id="dbSemester">
            <option selected="selected">Semester</option>
            @foreach ($dbSemester as $semester)
                <option value="{{ $semester->semester }}">{{ $semester->semester }}</option>
            @endforeach
        </select>
    </div>
</div>
<div class="col-md-2">
    <div class="form-group">
        <select class="custom-select" name="dbKelas" id="dbKelas">
            <option selected="selected">Kelas</option>
            @foreach ($dbKelas as $kelas)
                <option value="{{ $kelas->kelas }}">{{ $kelas->kelas }}</option>
            @endforeach
        </select>
    </div>
</div>
<div class="col-md-2">
    <div class="form-group">
        <select class="custom-select" name="dbPraktikum" id="dbPraktikum">
            <option selected="selected">Praktikum</option>
            @foreach ($dbPraktikum as $praktikum)
                <option value="{{ $praktikum->praktikum }}">{{ $praktikum->praktikum }}</option>
            @endforeach
        </select>
    </div>
</div>
<div class="col-md-2">
    <div class="form-group">
        <select class="custom-select" name="dbMatkul" id="dbMatkul">
            <option selected="selected">Mata Kuliah</option>
            @foreach ($dbMatkul as $matkul)
                <option value="{{ $matkul->nama_matkul }}">{{ $matkul->nama_matkul }}</option>
            @endforeach
        </select>
    </div>
</div>
<div class="col-md-2">
    <div class="form-group">
        <input type="date" name="dbTanggal" id="tanggal" class="form-control">
    </div>
</div>
<div class="col-md-2">
    <div class="form-group">
        <select class="custom-select" name="dbRuang">
            <option selected="selected">Kode Ruang</option>
            @foreach ($dbRuang as $ruang)
                <option value="{{ $ruang->ruangan }}">{{ $ruang->ruangan }}</option>
            @endforeach
        </select>
    </div>
</div>
<div class="col-md-1 align-content-center">
    <button type="submit" class="btn btn-primary py-2"><i class="fas fa-filter"></i></button>
</div>

<script>
    $('.matkul-select').select2();
</script>
{{-- <script>
    $(document).ready(function() {
        $('#dbProdi').on('change', function() {
            var prodi_id = $(this).val();
            if (prodi_id) {
                $.ajax({
                    url: '/getSemester/' + prodi_id,
                    type: "GET",
                    data: {
                        "_token": "{{ csrf_token() }}"
                    },
                    dataType: "json",
                    success: function(data) {
                        if (data) {
                            $('#dbSemester').empty();
                            $('#dbSemester').append(
                                '<option selected="selected">Semester</option>');
                            $.each(data, function(key, semester) {
                                $('select[name="dbSemester"]').append('<option value="' + semester.id + '">' + semester.semester + '</option>');
                            });
                        }else{
                            $('#dbSemester').empty();
                        }
                    }
                });
            }else{
                $('#dbSemester').empty();
            }
        });

        $('#dbSemester').on('change', function() {
            var semester_id = $(this).val();
            if(semester_id) {
                $.ajax({
                    url: '/getKelas/' + semester_id,
                    type: "GET",
                    data: {"_token":"{{ csrf_token() }}"},
                    dataType: "json",
                    success:function(data)
                    {
                        if(data){
                            $('#dbKelas').empty();
                            $('#dbKelas').append('<option selected="selected">Kelas</option>');
                            $.each(data, function(key, kelas){
                                $('select[name="dbKelas"]').append('<option value="'+ kelas.id +'">' + kelas.kelas + '</option>');
                            });
                        }else{
                            $('#dbKelas').empty();
                        }
                    }
                });

                $.ajax({
                    url: '/getMatkul/' + semester_id,
                    type: "GET",
                    data: {"_token":"{{ csrf_token() }}"},
                    dataType: "json",
                    success:function(data)
                    {
                        if(data){
                            $('#dbMatkul').empty();
                            $('#dbMatkul').append('<option selected="selected">Mata Kuliah</option>');
                            $.each(data, function(key, matkul){
                                $('select[name="dbMatkul"]').append('<option value="'+ matkul.id +'">' + matkul.nama_matkul + '</option>');
                            });
                        }else{
                            $('#dbMatkul').empty();
                        }
                    }
                });
            }else{
                $('#dbKelas').empty();
                $('#dbMatkul').empty();
            }
        });

        $('#dbKelas').on('change', function() {
            var kelas_id = $(this).val();
            if (kelas_id) {
                $.ajax({
                    url: '/getPrak/' + kelas_id,
                    type: "GET",
                    data: {
                        "_token": "{{ csrf_token() }}"
                    },
                    dataType: "json",
                    success: function(data) {
                        if (data) {
                            $('#dbPraktikum').empty();
                            $('#dbPraktikum').append(
                                '<option selected="selected">Praktikum</option>');
                            $.each(data, function(key, praktikum) {
                                $('select[name="dbPraktikum"]').append('<option value="' + praktikum.id + '">' + praktikum.praktikum + '</option>');
                            });
                        }else{
                            $('#dbPraktikum').empty();
                        }
                    }
                });
            }else{
                $('#dbPraktikum').empty();
            }
        });
    });
</script> --}}
