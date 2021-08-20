@extends('front.Master')
@section('content')
 <div class="vw_forum">
    <div class="container">
      <div class="vw_advertisement_footer">
        <img src="{{ asset('/frontend/images/vw_advertisement_footer.jpg') }}" alt="vw_advertisement_footer">
      </div>
     <div class="alien_ufo_header">
       <h2>Welcome to VoucherWins Forum</h2>
      </div>
      <div class="forum_table">
        <div class="table-responsive">
          <table class="table">
            <tr>
              <th>Topic</th>
              <th>Replies</th>
              <th>Views</th>
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
                  @if(isset($value['topic'])&&!empty ($value['topic']))
                 <a href="{{url('/forum/category/topic/'.$value['topicid']) }}">
                 <p>{!!$value['topic']!!}</p>
                  <p>by administrator <i class="fa fa-angle-double-right" aria-hidden="true"></i> {{date('D M j, Y g:i a',strtotime($value['date']))}}</p></a>


                  @endif 
                </div>
              </td>
              <td>
                <div>{{$value['postCount']}}</div>
              </td>
              <td>
                <div>0</div>
              </td>
              <td>
                <div>
                  @if(isset($value['post'])&&!empty ($value['post']))
                  <p>by {{ $value['username']}}</p>
                  <p> {!!$value['post']!!}</p>
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
        <img src="{{asset('/frontend/images/vw_advertisement_footer.jpg') }}" alt="vw_advertisement_footer">
      </div>
    </div>
  </div>
@stop