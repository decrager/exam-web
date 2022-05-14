@extends('layouts.app')

@section('main-content')
    <!-- header area start -->
    <div class="header-area">
        <div class="row align-items-center">
            <!-- nav and search button -->
            <div class="col-md-6 col-sm-8 clearfix">
                <div class="nav-btn pull-left">
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
            </div>
            <!-- profile info & task notification -->
            @include('layouts.profile')
        </div>
    </div>
    <!-- header area end -->

    <!-- page title area start -->
    <div class="page-title-area mb-3">
        <div class="row align-items-center">
            <div class="col-sm-6">
                <div class="breadcrumbs-area clearfix">
                    <h4 class="page-title pull-left">Jadwal Ujian</h4>
                    <ul class="breadcrumbs pull-left">
                        <li><a href="">Beranda</a></li>
                        <li><span>Jadwal Ujian</span></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- page title area end -->
    <div class="main-content-inner">
        <div class="row">
            <!-- data table start -->
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        @if (session()->has('success'))
                            <div class="alert alert-success" role="alert">
                                {{ session('success') }}
                            </div>
                        @endif
                        <h4 class="header-title">Daftar Jadwal Ujian</h4>
                        <div class="float-right">
                            <button class="btn btn-success py-2 mr-2" onclick="tablesToExcel(['dataTable'], ['Jadwal'], 'jadwal.xls', 'Excel')">Export &nbsp;&nbsp;<i
                                    class="fas fa-file-excel-o"></i></button>
                            <a href="/pj_ujian/jadwal/export" class="btn btn-primary py-2 mr-2">Export &nbsp;&nbsp;<i
                                class="fas fa-file-excel-o"></i></a>
                            <a href="{{ route('pjUjian.jadwal.tambah') }}"
                                class="btn btn-primary bg-blue float-right mb-3 py-2">
                                Tambah Jadwal
                            </a>
                        </div>
                        <div class="row justify-content-start">
                            @include('layouts.filter')
                        </div>

                        <div class="table-responsive">
                            <table id="dataTable" class="table" style="width: 100%">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Tanggal</th>
                                        <th class="col-2">Program Studi</th>
                                        <th>Semester</th>
                                        <th>Kelas</th>
                                        <th>Praktikum</th>
                                        <th class="col-2">Mata Kuliah</th>
                                        <th>Lokasi</th>
                                        <th>Kode Ruang</th>
                                        <th>Jam Mulai</th>
                                        <th>Jam Selesai</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($jadwal as $ujian)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $ujian->tanggal }}</td>
                                            <td>{{ $ujian->Matkul->Semester->Prodi->nama_prodi }}</td>
                                            <td>{{ $ujian->Matkul->Semester->semester }}</td>
                                            <td>{{ $ujian->Praktikum->Kelas->kelas }}</td>
                                            <td>{{ $ujian->Praktikum->praktikum }}</td>
                                            <td>{{ $ujian->Matkul->nama_matkul }}</td>
                                            <td>{{ $ujian->lokasi }}</td>
                                            <td>{{ $ujian->ruang }}</td>
                                            <td>{{ $ujian->jam_mulai }}</td>
                                            <td>{{ $ujian->jam_selesai }}</td>
                                            <td class="d-block">
                                                <form action="{{ route('pjUjian.jadwal.destroy', $ujian->id) }}" method="POST" class="btn-group" role="group">
                                                    <a class="btn btn-primary" data-bs-toggle="modal"
                                                        data-bs-target="{{ '#detail' . $ujian->id }}"><i
                                                            class="fas fa-info text-white"></i></a>
                                                    <a href="{{ route('pjUjian.jadwal.edit', $ujian->id) }}" class="btn btn-warning"><i class="fas fa-pen"></i></a>
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger" onclick="return confirm('Yakin ingin menghapus jadwal ujian ini?')"><i class="fas fa-trash"></i></button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
            <!-- data table end -->
        </div>
    </div>

    @foreach ($jadwal as $ujian)
        <div class="modal fade" id="{{ 'detail' . $ujian->id }}" tabindex="-1" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Detail</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <!-- Textual inputs start -->
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body p-2">
                                        <div class="row">
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <h6>Tanggal</h6>
                                                    <p>{{ $ujian->tanggal }}</p>
                                                </div>
                                                <div class="form-group">
                                                    <h6>Program Studi</h6>
                                                    <p>{{ $ujian->Matkul->Semester->Prodi->nama_prodi }}</p>
                                                </div>
                                                <div class="form-group">
                                                    <h6>Semester</h6>
                                                    <p>{{ $ujian->Matkul->Semester->semester }}</p>
                                                </div>
                                                <div class="form-group">
                                                    <h6>Kelas - Praktikum</h6>
                                                    <p>{{ $ujian->Praktikum->Kelas->kelas }} -
                                                        {{ $ujian->Praktikum->praktikum }}</p>
                                                </div>
                                                <div class="form-group">
                                                    <h6>Kode Mata Kuliah</h6>
                                                    <p>{{ $ujian->Matkul->kode_matkul }}</p>
                                                </div>
                                                <div class="form-group">
                                                    <h6>Mata Kuliah</h6>
                                                    <p>{{ $ujian->Matkul->nama_matkul }}</p>
                                                </div>
                                                <div class="form-group">
                                                    <h6>Lokasi</h6>
                                                    <p>{{ $ujian->lokasi }}</p>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <h6>Kode Ruang</h6>
                                                    <p>{{ $ujian->ruang }}</p>
                                                </div>
                                                <div class="form-group">
                                                    <h6>Jam Mulai - Jam Selesai</h6>
                                                    <p>{{ $ujian->jam_mulai }} - {{ $ujian->jam_selesai }}</p>
                                                </div>
                                                <div class="form-group">
                                                    <h6>Tipe Mata Kuliah</h6>
                                                    <p>{{ $ujian->tipe_mk }}</p>
                                                </div>
                                                <div class="form-group">
                                                    <h6>Sesi</h6>
                                                    <p>{{ $ujian->sesi }}</p>
                                                </div>
                                                <div class="form-group">
                                                    <h6>Software</h6>
                                                    <p>{{ $ujian->software }}</p>
                                                </div>
                                                <div class="form-group">
                                                    <h6>Pelaksanaan</h6>
                                                    <p>{{ $ujian->pelaksanaan }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Textual inputs end -->
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">
                            Close
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
    
    <script>
        var tablesToExcel = (function () {
          var uri = "data:application/vnd.ms-excel;base64,",
              tmplWorkbookXML =
                  '<?xml version="1.0"?><?mso-application progid="Excel.Sheet"?><Workbook xmlns="urn:schemas-microsoft-com:office:spreadsheet" xmlns:ss="urn:schemas-microsoft-com:office:spreadsheet">' +
                  '<DocumentProperties xmlns="urn:schemas-microsoft-com:office:office"><Author>Axel Richter</Author><Created>{created}</Created></DocumentProperties>' +
                  "<Styles>" +
                  '<Style ss:ID="Currency"><NumberFormat ss:Format="Currency"></NumberFormat></Style>' +
                  '<Style ss:ID="Date"><NumberFormat ss:Format="Medium Date"></NumberFormat></Style>' +
                  "</Styles>" +
                  "{worksheets}</Workbook>",
              tmplWorksheetXML =
                  '<Worksheet ss:Name="{nameWS}"><Table>{rows}</Table></Worksheet>',
              tmplCellXML =
                  '<Cell{attributeStyleID}{attributeFormula}><Data ss:Type="{nameType}">{data}</Data></Cell>',
              base64 = function (s) {
                  return window.btoa(unescape(encodeURIComponent(s)));
              },
              format = function (s, c) {
                  return s.replace(/{(\w+)}/g, function (m, p) {
                      return c[p];
                  });
              };
          return function (tables, wsnames, wbname, appname) {
              var ctx = "";
              var workbookXML = "";
              var worksheetsXML = "";
              var rowsXML = "";
        
              for (var i = 0; i < tables.length; i++) {
                  if (!tables[i].nodeType)
                      tables[i] = document.getElementById(tables[i]);
                  for (var j = 0; j < tables[i].rows.length; j++) {
                      rowsXML += "<Row>";
                      for (var k = 0; k < tables[i].rows[j].cells.length; k++) {
                          var dataType =
                              tables[i].rows[j].cells[k].getAttribute("data-type");
                          var dataStyle =
                              tables[i].rows[j].cells[k].getAttribute("data-style");
                          var dataValue =
                              tables[i].rows[j].cells[k].getAttribute("data-value");
                          dataValue = dataValue
                              ? dataValue
                              : tables[i].rows[j].cells[k].innerHTML;
                          var dataFormula =
                              tables[i].rows[j].cells[k].getAttribute("data-formula");
                          dataFormula = dataFormula
                              ? dataFormula
                              : appname == "Calc" && dataType == "DateTime"
                              ? dataValue
                              : null;
                          ctx = {
                              attributeStyleID:
                                  dataStyle == "Currency" || dataStyle == "Date"
                                      ? ' ss:StyleID="' + dataStyle + '"'
                                      : "",
                              nameType:
                                  dataType == "Number" ||
                                  dataType == "DateTime" ||
                                  dataType == "Boolean" ||
                                  dataType == "Error"
                                      ? dataType
                                      : "String",
                              data: dataFormula ? "" : dataValue,
                              attributeFormula: dataFormula
                                  ? ' ss:Formula="' + dataFormula + '"'
                                  : "",
                          };
                          rowsXML += format(tmplCellXML, ctx);
                      }
                      rowsXML += "</Row>";
                  }
                  ctx = { rows: rowsXML, nameWS: wsnames[i] || "Sheet" + i };
                  worksheetsXML += format(tmplWorksheetXML, ctx);
                  rowsXML = "";
              }
        
              ctx = { created: new Date().getTime(), worksheets: worksheetsXML };
              workbookXML = format(tmplWorkbookXML, ctx);
        
              console.log(workbookXML);
        
              var link = document.createElement("A");
              link.href = uri + base64(workbookXML);
              link.download = wbname || "Workbook.xls";
              link.target = "_blank";
              document.body.appendChild(link);
              link.click();
              document.body.removeChild(link);
          };
        })();
    </script>
@endsection
