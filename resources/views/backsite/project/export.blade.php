
<h2>Data Karya {{ $statusText }}</h2>
<table style="background-color: red;">
    <!-- <colgroup>
        <col span="1" style="width: 3%;">
        <col span="1" style="width: 50%;">
        <col span="1" style="width: 60%;">
        <col span="1" style="width: 20%;">
        <col span="1" style="width: 20%;">
    </colgroup> -->
    <thead>
        <tr>
            <th>NO</th>
            <th width="250px">JUDUL</th>
            <th width="200px">KATEGORI</th>
            <th width="200px">PRODI</th>
            <th width="150px">EMAIL</th>
            <th width="150px">NRP</th>
            <th width="250px">NAMA ANGGOTA</th>
        </tr>
    </thead>
    <tbody style="border-style: 5px dashed #CCC;">
        @forelse ($excel as $xl)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $xl->title }}</td>
            <td>{{ $xl->category->name ?? "Kosong" }}</td>
            @if (!empty($xl->major->name))
                <td>{{ $xl->major->name }}</td>
            @elseif (!empty($xl->projectUsers[0]->custom_major))
                <td>{{ $xl->projectUsers[0]->custom_major }}</td>
            @else
                <td>Kosong</td>
            @endif
            <td>
                @foreach ($xl->projectUsers as $member)
                    {{ $member->email }}<br>
                @endforeach
            </td>
            <td>
                @foreach ($xl->projectUsers as $member)
                    {{ $member->nrp }}<br>
                @endforeach
            </td>
            <td>
                @foreach ($xl->projectUsers as $member)
                    {{ $member->name }}<br>
                @endforeach
            </td>
        </tr>
        @empty
        @endforelse
    </tbody>
</table>