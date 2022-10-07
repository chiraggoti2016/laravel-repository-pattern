@extends('Mails.base')
@section('title', 'Verify Email')
@section('subject', 'Verify your email address')
@section('content')
  <table style="font-family:'Lato',sans-serif;" role="presentation" cellpadding="0" cellspacing="0" width="100%" border="0">
      <tbody>
          <tr>
              <td style="overflow-wrap:break-word;word-break:break-word;padding:10px 44px 30px;font-family:'Lato',sans-serif;" align="left">
                  
                  <div style="color: #333333; line-height: 200%; text-align: left; word-wrap: break-word;">
                      <p style="font-size: 14px; line-height: 200%;"><span style="font-size: 16px; line-height: 32px;">Hi, {{ $user->name }}</span></p>
                      <p style="font-size: 14px; line-height: 200%;"><span style="font-size: 16px; line-height: 32px;">Thank you for registering as a user {{ isset($user->partner->name) ? 'with partner ' . $user->partner->name : null }}. You're almost ready to get started.</span></p>
                      <p style="font-size: 14px; line-height: 200%;"> </p>
                      <p style="font-size: 14px; line-height: 200%;"><span style="font-size: 16px; line-height: 32px;">Please click on the button below to verify your email address. </span></p>
                  </div>

              </td>
          </tr>
      </tbody>
  </table>

  <table id="u_content_button_1" style="font-family:'Lato',sans-serif;" role="presentation" cellpadding="0" cellspacing="0" width="100%" border="0">
      <tbody>
          <tr>
              <td style="overflow-wrap:break-word;word-break:break-word;padding:10px;font-family:'Lato',sans-serif;" align="left">
                  
                  <div align="center">
                      <!--[if mso]><table width="100%" cellpadding="0" cellspacing="0" border="0" style="border-spacing: 0; border-collapse: collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;font-family:'Lato',sans-serif;"><tr><td style="font-family:'Lato',sans-serif;" align="center"><v:roundrect xmlns:v="urn:schemas-microsoft-com:vml" xmlns:w="urn:schemas-microsoft-com:office:word" href="{{ route('user.verify', $token) }}" style="height:60px; v-text-anchor:middle; width:371px;" arcsize="5%" stroke="f" fillcolor="#1479f8"><w:anchorlock/><center style="color:#FFFFFF;font-family:'Lato',sans-serif;"><![endif]-->
                          <a href="{{ route('verification.verify', $token) }}" target="_blank" class="v-size-width" style="box-sizing: border-box;display: inline-block;font-family:'Lato',sans-serif;text-decoration: none;-webkit-text-size-adjust: none;text-align: center;color: #FFFFFF; background-color: #1479f8; border-radius: 3px;-webkit-border-radius: 3px; -moz-border-radius: 3px; width:64%; max-width:100%; overflow-wrap: break-word; word-break: break-word; word-wrap:break-word; mso-border-alt: none;">
                              <span style="display:block;padding:19px 30px;line-height:120%;"><span style="font-size: 18px; line-height: 21.6px;"><strong><span style="line-height: 21.6px; font-family: 'Open Sans', sans-serif; font-size: 18px;">V E R I F Y&nbsp; &nbsp;E M A I L</span></strong></span></span>
                          </a>
                      <!--[if mso]></center></v:roundrect></td></tr></table><![endif]-->
                  </div>

              </td>
          </tr>
      </tbody>
  </table>

@endsection