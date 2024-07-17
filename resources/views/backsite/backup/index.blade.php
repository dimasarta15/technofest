@extends('layouts.backsite-layout')
@section('menuBackup', 'active')

@section('content')
<div class="main-panel">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <a href="{{ route(getLang() . 'backsite.backup.run') }}" class="btn btn-primary btn-rounded btn-sm"><i class="mdi mdi-backup-restore menu-icon"></i> @trans('backsite.backup.run') </a>
                        <div class="table-responsive">
                            <table id="datatables" class="table table-striped table-no-bordered table-hover dtable" cellspacing="0" width="100%" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Filename</th>
                                        <!-- <th>Created Date</th> -->
                                        <th class="disabled-sorting text-right">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($backups as $bk)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $bk }}</td>
                                        <td>
                                            <a type="button" rel="tooltip" class="btn btn-sm btn-success btn-round" data-original-title="" title="" href="/storage/{{ $bk }}">
                                                <i class="mdi mdi-cloud-download menu-icon"></i>
                                                <div class="ripple-container"></div>
                                            </a>
                                            <a rel="tooltip" class="btn btn-sm btn-danger btn-round btn_delete" id="{{ $bk }}" data-original-title="" title="">
                                                <i class="mdi mdi-delete"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="3"><center>Data is empty</center></td>
                                    </tr>
                                    @endforelse
                                </tbody>
                                <!-- <tfoot>
                                    <tr>
                                        <th>No</th>
                                        <th>Filename</th>
                                        <th class="disabled-sorting text-right">Actions</th>
                                    </tr>
                                </tfoot> -->
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!-- end content-->
                </div>
                <!--  end card  -->
            </div>
            <!-- end col-md-12 -->
        </div>
        <!-- end row -->
    </div>
</div>
@endsection

@section('script')
<script>
    let appName = '{{ str_replace(" ", "-", env("APP_NAME", "laravel-backup")) }}'
    $(document).on('click', '.btn_delete', function(e) {
        e.preventDefault()
        let v = $(this).attr('id')
        Swal.fire({
            icon: 'warning',
            title: 'Are You Sure ?',
            text: "Are you sure to delete this item!",
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it !'
        }).then((result) => {
            if (result.isConfirmed) {
                location.href = "/backsite/backup/destroy/"+v.replace(appName+'/', "", v)
            }
        });
    })
</script>
@endsection