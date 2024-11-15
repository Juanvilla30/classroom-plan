<table>
    <thead>
        <tr>
            <th>Aula</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($data['classroom'] as $classroom)
        <tr>
            <td>{{ $classroom->relations->course->name_course ?? 'Sin nombre' }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
