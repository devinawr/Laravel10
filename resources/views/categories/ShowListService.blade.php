<ul>
@forelse ($data as $f)
  <li>{{ $f->service_name }}</li>
@empty
  <li>Tidak ada service</li>
@endforelse
</ul>