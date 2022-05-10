<div class="col-md-2">
    <div class="form-group">
        <select class="custom-select" name="prodi" id="prodi">
            <option selected="selected">Program Studi</option>
            @foreach ($dbProdi as $prodi)
                <option value="{{ $prodi->id }}">{{ $prodi->nama_prodi }}</option>
            @endforeach
        </select>
    </div>
</div>
<div class="col-md-2">
    <div class="form-group">
        <select class="custom-select" name="semester" id="semester">
            <option selected="selected">Semester</option>
        </select>
    </div>
</div>
<div class="col-md-2">
    <div class="form-group">
        <select class="custom-select" name="kelas" id="kelas">
            <option selected="selected">Kelas</option>
        </select>
    </div>
</div>
<div class="col-md-2">
    <div class="form-group">
        <select class="custom-select" name="praktikum" id="praktikum">
            <option selected="selected">Praktikum</option>
        </select>
    </div>
</div>
<div class="col-md-2">
    <div class="form-group">
        <select class="custom-select" name="matkul" id="matkul">
            <option selected="selected">Mata Kuliah</option>
        </select>
    </div>
</div>
<div class="col-md-2">
    <div class="form-group">
        <input type="date" name="tanggal" id="tanggal" class="form-control">
    </div>
</div>
<div class="col-md-2">
    <div class="form-group">
        <select class="custom-select">
            <option selected="selected">Kode Ruang</option>
            @foreach ($dbRuang as $ruang)
                <option value="{{ $ruang->ruang }}">{{ $ruang->ruang }}</option>
            @endforeach
        </select>
    </div>
</div>
<div class="col-md-1 align-content-center">
    <button class="btn btn-primary py-2"><i class="fas fa-filter"></i></button>
</div>

<script>
    $(document).ready(function() {
        $('#prodi').on('change', function() {
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
                            $('#semester').empty();
                            $('#semester').append(
                                '<option selected="selected">Semester</option>');
                            $.each(data, function(key, semester) {
                                $('select[name="semester"]').append('<option value="' + semester.id + '">' + semester.semester + '</option>');
                            });
                        }else{
                            $('#course').empty();
                        }
                    }
                });
            }else{
                $('#course').empty();
            }
        });

        $('#semester').on('change', function() {
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
                            $('#kelas').empty();
                            $('#kelas').append('<option selected="selected">Kelas</option>');
                            $.each(data, function(key, kelas){
                                $('select[name="kelas"]').append('<option value="'+ kelas.id +'">' + kelas.kelas + '</option>');
                            });
                        }else{
                            $('#kelas').empty();
                        }
                    }
                });
            }else{
                $('#kelas').empty();
            }
        });
    });
</script>
