@extends('cms::panel.mail.app')

@section('content')
    <table align="center" role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%" style="margin: auto;">
        <tr>
            <td class="bg_white email-section">
                <div class="heading-section" style="text-align: center;">
                    <a href="{!! env('APP_URL') !!}">
                        <p><img src="{!! asset('images/logo.png') !!}" style="width:30%;"></p>
                    </a>
                    <h2>{!! trans('cms::ebulletin.activated_mail_1') !!}</h2>
                    <br><br>
                    <div>{!! trans('cms::ebulletin.activated_mail_2') !!}</div>
                    <a class="btn btn-danger" href="{!! route('ebulletin-cancel',['token' => $data->activate_token]) !!}">{!! trans('cms::ebulletin.activated_mail_cancel') !!}</a>
                    <div>{!! trans('cms::ebulletin.activated_mail_3') !!}</div>
                    <div style="color:black;word-wrap:break-word;">{!! route('ebulletin-cancel',['token' => $data->activate_token]) !!}</div>
                </div>

            </td>
        </tr>
    </table>
@endsection
