@extends('cms::panel.mail.app')

@section('content')
    <table align="center" role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%" style="margin: auto;">
        <tr>
            <td class="bg_white email-section">
                <div class="heading-section" style="text-align: center;">
                    <a href="{!! env('APP_URL') !!}">
                        <p><img src="{!! asset('images/logo.png') !!}" style="width:30%;"></p>
                    </a>
                    <h2>{!! trans('cms::ebulletin.activation_mail_1') !!}</h2>
                    <a class="btn btn-primary" href="{!! route('ebulletin-activate',['token' => $data->activate_token]) !!}">{!! trans('cms::ebulletin.activation_mail_activate') !!}</a>
                    <br><br>
                    <div>{!! trans('cms::ebulletin.activation_mail_2') !!}</div>
                    <div style="color:black;word-wrap:break-word;">{!! route('ebulletin-activate',['token' => $data->activate_token]) !!}</div>
                </div>

            </td>
        </tr>
    </table>
@endsection
