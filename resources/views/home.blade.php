@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card text-white bg-secondary">
                <div class="card-header">樂透遊戲</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <table class="table table-bordered">
                      <thead>
                        <tr>
                          <th scope="col">錢包位址</th>
                          <th scope="col">錢包餘額</th>
                          <th scope="col">下注人數</th>
                          <th scope="col">累積獎金</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <td>{{ Auth::user()->ethereum_address }}</td>
                          <td><span id="balance">{{ $balance }}</span> ETH</td>
                          <td><span id="people">{{ $people }}</span> 人</td>
                          <td><span id="total_balance">{{ $total_balance }}</span> ETH</td>
                        </tr>
                      </tbody>
                    </table>

                    @if(auth()->user()->is_owner=='1')
                      <div class="input-group">
                        <button id="pick_winner" class="btn btn-primary" type="button">開獎</button>
                      </div>
                    @else
                      <div class="input-group">
                        <input id="value" type="text" class="form-control" placeholder="輸入下注金額 (最低 0.0001 ETH)" aria-describedby="button-addon4" value="0">
                        <div class="input-group-append">
                          <span class="input-group-text">ETH</span>
                        </div>
                        <div class="input-group-append" id="button-addon4">
                          <button id="enter" class="btn btn-primary" type="button">下注</button>
                        </div>
                      </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.18.0/axios.min.js"></script>
<script>
$(function(){
    $('#enter').click(function(){
        if($('#value').val() <= 0.0001){
            alert('必須下注超過 0.0001 ETH');
        }else{
            axios.post('/enter', {
                value: $('#value').val()
            })
            .then(function (response) {
                $('#balance').html(response.data['balance'])
                $('#people').html(response.data['people'])
                $('#total_balance').html(response.data['total_balance'])
                $('#value').val(0)
                if(response.data['status']){
                    alert('下注成功')
                }else{
                    alert('下注失敗')
                }
            })
            .catch(function (error) {
                $('#value').val(0)
                alert('下注失敗')
                console.log(error)
            })
        }
    })
    $('#pick_winner').click(function(){
        axios.get('/pick_winner')
          .then(function (response) {
              $('#balance').html(response.data['balance'])
              $('#people').html(response.data['people'])
              $('#total_balance').html(response.data['total_balance'])
              $('#value').val(0)
              if(response.data['status']){
                  alert('開獎完成')
              }else{
                  alert('開獎失敗')
              }
          })
          .catch(function (error) {
              alert('開獎失敗')
              console.log(error)
          })
    })
})
</script>
@endsection
