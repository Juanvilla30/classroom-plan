<table>
    <thead>
        <tr>
            <th>Curso</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($data as $dat)
        <tr>
            <th>{{ $dat }}</th>
        </tr>
        @endforeach
    </tbody>
</table>
