
<h2>Data Kuesioner {{ $semester->semester }}</h2>
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
            @forelse($excel as $xl)
            <th width="170px">{{ $xl->label }}</th>
            @empty
            @endforelse
        </tr>
    </thead>
    <tbody style="border-style: 5px dashed #CCC;">
        @forelse ($responses as $rs)
            <tr>
                <td>{{ $loop->iteration }}</td>
                @forelse($rs as $r)
                    <td>{{ str_replace(['"', ']', '['], '', $r['value']) }}</td>
                @empty
                @endforelse
            </tr>
        @empty
        @endforelse
    </tbody>
</table>