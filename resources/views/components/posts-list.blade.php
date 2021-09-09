<div class="m-4 p-4">
    <!-- Be present above all else. - Naval Ravikant -->
   
    <table class="table  table-hover">
        <thead>
          <tr>
            <th scope="col">제목</th>
            <th scope="col">작성자</th>
            <th scope="col">작성일</th>
          </tr>
        </thead>
        <tbody>
          @foreach($posts as $post)
            <tr>
              <td>{{ $post->title }}</td>
              <td>{{ $post->writer->name }}</td>
              <td>{{ $post->created_at->diffForHumans() }}</td>
            </tr>
          @endforeach
        </tbody>
      </table>
</div>