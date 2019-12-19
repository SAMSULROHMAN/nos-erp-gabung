<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>NOS-ERP</title>

        <!-- Bootstrap -->
    <link href="{{ url('vendors/bootstrap/dist/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ url('css/custom.min.css') }}" rel="stylesheet">
    <link href="{{ url('vendors/select2/dist/css/select2.css') }}" rel="stylesheet">
      <meta name="csrf-token" content="{{ csrf_token() }}">

  </head>

  <body class="login">
    <div class="">
      <a class="hiddenanchor" id="signup"></a>
      <a class="hiddenanchor" id="signin"></a>

      <div class="login_wrapper">
        <div class="animate form login_form">
          <section class="login_content">
            <form method="POST" action="{{ route('login') }}" class="">
                {{ csrf_field() }}
              <h1>NOS-ERP</h1>
              <div class="form-group has-feedback" {{ $errors->has('name') ? 'has-error' : ''}}>
                <input type="text" id="email" name="email" class="form-control" placeholder="Username" required="" />
                @if ($errors->has('email'))
                    <span class="help-block text-danger">
                        <strong>{{ $errors->first('email')}}</strong>
                    </span>
                @endif
              </div>
              <div {{ $errors->has('password') ? 'has-error' : ''}}>
                <input type="password" name="password" class="form-control" placeholder="Password" required="" />
                @if ($errors->has('password'))
                    <span class="help-block text-danger">
                        <strong>{{ $errors->first('password')}}</strong>
                    </span>
                @endif
              </div>

              {{--<div class="form-group">
                <select class="form-control" name="KodeLokasi" id="Lok">
                  @foreach ($lokasi as $l)
                    <option value="{{ $l->KodeLokasi }}">{{ $l->NamaLokasi }}</option>
                  @endforeach
                </select>
              </div>--}}

              <div class="form-group">
                <button type="submit" value="Login" class="btn btn-md btn-block btn-primary">Login</button>
              </div>
              <div class="clearfix"></div>
            </form>
          </section>
        </div>
      </div>
    </div>
  </body>
  <script src="{{ asset('vendors/jquery/dist/jquery.js')}}"></script>
  <script src="{{ asset('vendors/select2/dist/js/select2.js') }}"></script>
  <script>
      $(document).ready(function(){
        $('#Lok').select2();
      });
  </script>
</html>
