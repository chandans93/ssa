@extends('front.Master')
@section('content')
	<div class="vw_forum">
    <div class="container">
      <div class="vw_advertisement_footer">
        <img src="{{ asset('/frontend/images/vw_advertisement_footer.jpg') }}"  alt="vw_advertisement_footer">
      </div>
     <div class="alien_ufo_header">
       <h2>Welcome to VoucherWins Forum</h2>
      </div>
      <div class="forum_table">
        <div class="table-responsive">
          <table class="table">
            <tr>
              <th>Category</th>
              <th>Topics</th>
              <th>Posts</th>
              <th>Last Post</th>
            </tr>
            @if(!isset($data) || empty($data))
            <tr>
            <td colspan="4">{{trans('frontlabels.NoRecordFound')}}</td> 
            </tr>
            @else
            @foreach ($data as $value)
            <tr>
              <td>
                <div class="forum_title">
                <a href="{{url('/forum/category/'.$value['id']) }}">
                  <p>{{$value['fc_name']}}</p></a>
                </div>
              </td>
              <td>
                <div>{{$value['TopicCount']}}</div>
              </td>
              <td>
                <div>{{$value['postCount']}}</div>
              </td>
              <td>
                <div>
                  @if(isset($value['post'])&&!empty ($value['post']))
                    <p> {!!$value['post']!!}</p>
                    <p>by {{ $value['username']}}</p>
                    <p>{{date('D M j, Y g:i a',strtotime($value['post_time']))}}</p>
                  @else
                  <p>-</p>
                  @endif 
                </div>
              </td>
            </tr>
            @endforeach
            @endif
          </table>
        </div>
      </div>
      <div class="vw_advertisement_footer">
        <img src="{{ asset('/frontend/images/vw_advertisement_footer.jpg') }}" alt="vw_advertisement_footer">
      </div>
    </div>
  </div>
@stop

@section('script')
<script src="{{ asset('frontend/js/moment-with-locales.js') }}"></script>
@stop