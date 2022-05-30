<div class="col-md-2">
    <div class="form-group">
        <select class="custom-select" name="dbProdi" id="dbProdi">
            @if (request('dbProdi'))
                <option value="">Program Studi</option>
                <option selected="selected" value="{{ request('dbProdi') }}">{{ request('dbProdi') }}</option>
            @else
                <option selected="selected" value="">Program Studi</option>
            @endif
            @foreach ($dbProdi as $prodi)
                <option value="{{ $prodi->nama_prodi }}">{{ $prodi->nama_prodi }}</option>
            @endforeach
        </select>
    </div>
</div>
<div class="col-auto">
    <div class="form-group">
        <select class="custom-select" name="dbSemester" id="dbSemester">
            @if (request('dbSemester'))
                <option value="">Semester</option>
                <option selected="selected" value="{{ request('dbSemester') }}">{{ request('dbSemester') }}</option>
            @else
                <option selected="selected" value="">Semester</option>
            @endif
            @foreach ($dbSemester as $semester)
                <option value="{{ $semester->semester }}">{{ $semester->semester }}</option>
            @endforeach
        </select>
    </div>
</div>
<div class="col-auto">
    <div class="form-group">
        <select class="custom-select" name="dbKelas" id="dbKelas">
            @if (request('dbKelas'))
                <option value="">Kelas</option>
                <option selected="selected" value="{{ request('dbKelas') }}">{{ request('dbKelas') }}</option>
            @else
                <option selected="selected" value="">Kelas</option>
            @endif
            @foreach ($dbKelas as $kelas)
                <option value="{{ $kelas->kelas }}">{{ $kelas->kelas }}</option>
            @endforeach
        </select>
    </div>
</div>
<div class="col-auto">
    <div class="form-group">
        <select class="custom-select" name="dbPraktikum" id="dbPraktikum">
            @if (request('dbPraktikum'))
                <option value="">Praktikum</option>
                <option selected="selected" value="{{ request('dbPraktikum') }}">{{ request('dbPraktikum') }}</option>
            @else
                <option selected="selected" value="">Praktikum</option>
            @endif
            @foreach ($dbPraktikum as $praktikum)
                <option value="{{ $praktikum->praktikum }}">{{ $praktikum->praktikum }}</option>
            @endforeach
        </select>
    </div>
</div>
<div class="col-md-2">
    <div class="form-group">
        <select class="custom-select matkul-select" name="dbMatkul" id="dbMatkul">
            @if (request('dbMatkul'))
                <option value="">Mata Kuliah</option>
                <option selected="selected" value="{{ request('dbMatkul') }}">{{ request('dbMatkul') }}</option>
            @else
                <option selected="selected" value="">Mata Kuliah</option>
            @endif
            @foreach ($dbMatkul as $matkul)
                <option value="{{ $matkul->nama_matkul }}">{{ $matkul->nama_matkul }}</option>
            @endforeach
        </select>
    </div>
</div>
<div class="col-auto">
    <div class="form-group">
        <input type="date" name="dbTanggal" id="tanggal" class="form-control">
    </div>
</div>
<div class="col-auto">
    <div class="form-group">
        <select class="custom-select" name="dbRuang">
            @if (request('dbRuang'))
                <option value="">Ruang</option>
                <option selected="selected" value="{{ request('dbRuang') }}">{{ request('dbRuang') }}</option>
            @else
                <option selected="selected" value="">Kode Ruang</option>
            @endif
            @foreach ($dbRuang as $ruang)
                <option value="{{ $ruang->ruangan }}">{{ $ruang->ruangan }}</option>
            @endforeach
        </select>
    </div>
</div>
<div class="col-md-1 align-content-center">
    <button type="submit" class="btn btn-primary py-2"> <i class="fas fa-filter"></i></button>
</div>

<script>
    $('.matkul-select').select2({
        theme: 'bootstrap-5',
        dropdownCssClass: "select2--small",
    });
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
                                '<option selected="selected" value="">Semester</option>');
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
                            $('#dbKelas').append('<option selected="selected" value="">Kelas</option>');
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
                            $('#dbMatkul').append('<option selected="selected" value="">Mata Kuliah</option>');
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
                                '<option selected="selected" value="">Praktikum</option>');
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
