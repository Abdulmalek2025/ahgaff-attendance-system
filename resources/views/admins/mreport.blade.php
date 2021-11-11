<h2>Master View</h2>
<div class=" mt-3 mb-5">
    <div class="row m-auto">
        <div class="col-sm-12">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>

                    <tr>
                        <th scope="col">Collage</th>
                        <th scope="col">Phone</th>
                        <th scope="col">Dean</th>
                        <th scope="col">Register</th>
                    </tr>
                    </tr>
                </thead>
                <tbody class="data-cont">
                @foreach ($rows as $row)
                @if($row[3][0])
                    <tr>
                        <td>{{$row[0]}}</td>
                        <td>{{$row[1]}}</td>
                        <td>{{$row[2]}}</td>
                        <td>{{$row[3][0]}}</td>
                    </tr>
                @elseif ($row[3][1])
                    <tr>
                        <td>{{$row[0]}}</td>
                        <td>{{$row[1]}}</td>
                        <td>{{$row[2]}}</td>
                        <td>{{$row[3][1]}}</td>
                    </tr>
                @endif
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
