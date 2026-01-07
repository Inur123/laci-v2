@if($isHtml)
    {!! $isi !!}
@else
    <p><strong>{{ $judul }}</strong></p>
    {!! nl2br(e($isi)) !!}
    <hr>
    <p style="font-size:12px;color:#666;">
        Dikirim oleh: {{ $pengirim }}
    </p>
@endif
