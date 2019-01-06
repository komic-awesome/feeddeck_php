<div>
  <h2>
    {{ $name }}

    @if(! empty($location))
      （{{$location}}）
    @endif
  </h2>

  <div>
    <a href="{{ $url }}" title="{{ $name }}">
      <img src="{{ $avatar_url }}" alt="{{ $name }}" style="width:120px;height:120px">
    </a>
  </div>

  @if(! empty($bio_html))
    <div>
      <h3>
        简介：
      </h3>
      {!! $bio_html !!}
    </div>
  @endif

  @if(! empty($company_html))
    <div>
      <h3>
        公司：
      </h3>
      {!! $company_html !!}
    </div>
  @endif

  <p>
    @if(! empty($website_url))
      <a href="{{ $website_url }}">个人网站</a>
      和
    @endif
    <a href="{{ $url }}">Github 地址</a>
  </p>

  @if(! empty($email))
    <p>
      公开邮箱：{{ $email }}
    </p>
  @endif
</div>
