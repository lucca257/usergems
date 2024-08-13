<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Morning Update</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            border: 1px solid #ddd;
            padding: 20px;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .header img {
            width: 150px;
        }

        .header h1 {
            color: #00a3d7;
        }

        .meeting {
            border-top: 1px solid #ddd;
            padding: 10px 0;
        }

        .time {
            color: #00a3d7;
            font-weight: bold;
        }

        .meeting-info {
            margin-top: 10px;
        }

        .participant {
            display: flex;
            align-items: center;
            margin-top: 10px;
        }

        .participant img {
            border-radius: 50%;
            width: 50px;
            height: 50px;
            margin-right: 10px;
        }

        .name {
            font-weight: bold;
        }

        .position {
            color: #777;
        }

        .linkedin {
            color: #00a3d7;
            text-decoration: none;
            margin-left: 5px;
        }

        .status {
            margin-left: auto;
            display: flex;
            align-items: center;
        }

        .status img {
            width: 20px;
            height: 20px;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="header">
        <a href="/" aria-current="page" class="brand w-inline-block w--current">
            <svg viewBox="0 0 220 32" fill="none" width="65%">
                <path fill-rule="evenodd" clip-rule="evenodd"
                      d="M181.849 11.635v12.789a.897.897 0 0 1-.884.906h-1.844a.898.898 0 0 1-.884-.906V7.11c0-.498.398-.906.884-.906h1.844a.866.866 0 0 1 .603.244l6.702 6.293 6.672-6.292a.858.858 0 0 1 .604-.245h1.844c.418 0 .907.347.878.935v17.277a.897.897 0 0 1-.884.906h-1.844a.897.897 0 0 1-.884-.906V11.64l-5.784 5.495c-.365.357-.879.288-1.176.035l-.015-.014-5.832-5.52Zm-110.635 7.58c0 2.099-.353 3.485-1.446 4.604l-.002.002c-1.093 1.111-2.476 1.504-4.492 1.504h-6.746c-2.01 0-3.407-.384-4.496-1.509-1.083-1.117-1.444-2.499-1.444-4.6V7.158c0-.499.398-.906.884-.906h1.844c.487 0 .885.407.885.906v11.724c0 .743.04 1.286.127 1.69.086.393.207.604.335.735.127.13.333.254.718.342.393.09.923.131 1.649.131h5.735c.726 0 1.256-.041 1.65-.131.384-.088.59-.211.718-.342.128-.131.248-.342.334-.736.088-.403.128-.946.128-1.69V7.16c0-.499.398-.906.884-.906h1.844a.9.9 0 0 1 .886.816l.005.045v12.101Zm17.484-1.142.003.003.003.002c.223.205.385.474.385 1.58 0 1.082-.2 1.481-.451 1.688-.31.255-.943.435-2.327.435H75.965a.898.898 0 0 0-.884.906v1.732c0 .499.397.906.884.906H86.82c1.98 0 3.347-.396 4.455-1.498 1.04-1.034 1.428-2.357 1.428-4.169 0-1.774-.391-3.078-1.416-4.13-1.086-1.142-2.435-1.511-4.473-1.511h-6.117c-1.385 0-2.019-.178-2.33-.432-.25-.203-.449-.594-.449-1.665 0-1.082.2-1.481.451-1.688.311-.255.943-.435 2.328-.435h10.365a.898.898 0 0 0 .884-.906V7.16a.898.898 0 0 0-.884-.906H80.193c-1.974 0-3.345.388-4.454 1.5-1.04 1.033-1.428 2.355-1.428 4.167 0 1.777.402 3.124 1.43 4.143v.001c1.113 1.1 2.48 1.497 4.453 1.497h6.117c1.6 0 2.038.186 2.387.512Zm63.139 3.703v-6.858c0-.498.398-.906.884-.906h1.692c.503 0 .836.407.885.806l.005.05v9.553a.898.898 0 0 1-.884.906H142.84c-2.013 0-3.399-.385-4.494-1.507l-.003-.002c-1.082-1.117-1.443-2.499-1.443-4.601v-6.885c0-2.082.354-3.46 1.446-4.577l.002-.002c1.093-1.112 2.476-1.505 4.492-1.505h9.9c.487 0 .885.408.885.906v1.732a.898.898 0 0 1-.885.906h-9.398c-.726 0-1.255.041-1.649.131-.385.088-.59.211-.718.343-.128.13-.249.341-.334.735-.088.403-.128.946-.128 1.69v6.187c0 .744.04 1.286.128 1.69.085.394.206.604.334.735.128.131.333.255.718.342.394.09.923.131 1.649.131h8.495Zm64.042-3.703.003.003.003.002c.223.205.386.474.386 1.58 0 1.082-.2 1.481-.451 1.688-.311.255-.943.435-2.328.435h-10.346a.898.898 0 0 0-.884.906v1.732c0 .499.398.906.884.906h10.855c1.978 0 3.347-.396 4.454-1.498 1.041-1.034 1.428-2.357 1.428-4.169 0-1.775-.391-3.079-1.417-4.132-1.084-1.131-2.43-1.51-4.472-1.51h-6.116c-1.386 0-2.019-.178-2.331-.431-.249-.203-.448-.594-.448-1.665 0-1.082.2-1.481.451-1.688.311-.255.943-.435 2.328-.435h10.364a.898.898 0 0 0 .885-.906V7.16a.898.898 0 0 0-.885-.906h-10.867c-1.975 0-3.346.388-4.455 1.5-1.04 1.033-1.427 2.355-1.427 4.167 0 1.777.402 3.124 1.429 4.143l.001.001c1.112 1.1 2.479 1.497 4.452 1.497h6.117c1.6 0 2.039.186 2.387.512ZM99.272 21.78h12.61c.208 0 .442.075.627.264a.919.919 0 0 1 .257.642v1.732a.898.898 0 0 1-.884.906H96.544a.898.898 0 0 1-.884-.905V7.159c0-.499.398-.906.884-.906h15.338c.486 0 .884.407.884.906V8.89a.898.898 0 0 1-.884.906h-12.61v4.22h8.381c.487 0 .884.407.884.906v1.706a.897.897 0 0 1-.884.906h-8.38v4.246Zm75.485 0h-12.61v-4.246h8.381a.897.897 0 0 0 .884-.906v-1.706a.897.897 0 0 0-.884-.906h-8.381v-4.22h12.61a.898.898 0 0 0 .884-.906V7.16a.898.898 0 0 0-.884-.906h-15.338a.897.897 0 0 0-.884.906v17.26c0 .499.397.906.884.906h15.338a.898.898 0 0 0 .884-.905v-1.733a.919.919 0 0 0-.257-.642.875.875 0 0 0-.627-.264Zm-44.746-2.638 4.104 4.695.021.027a.95.95 0 0 1 .168.397.903.903 0 0 1-.11.612.893.893 0 0 1-.765.45h-2.548a.885.885 0 0 1-.633-.268l-.025-.026-4.727-5.75h-6.481v5.144a.898.898 0 0 1-.885.906h-1.861a.898.898 0 0 1-.885-.906V7.11c0-.503.402-.906.885-.906h11.885c2.029 0 3.425.386 4.528 1.509l.002.002c1.092 1.12 1.457 2.506 1.457 4.615v.83c0 2.105-.357 3.495-1.458 4.616-.727.745-1.585 1.166-2.672 1.366Zm.505-6.316v-.156c0-1.558-.189-2.15-.467-2.432-.13-.133-.339-.257-.729-.346-.398-.09-.934-.132-1.667-.132h-8.625v5.976h8.625c.733 0 1.269-.042 1.667-.132.39-.089.599-.213.729-.346.278-.283.467-.874.467-2.431Z"
                      fill="currentColor"></path>
                <path fill-rule="evenodd" clip-rule="evenodd"
                      d="M44.007 9.204 35.147.15H8.805L0 9.204l22.003 22.539L44.007 9.204ZM32.44 4.594l-2.986-.016h-2.968l-4.394 4.5 7.363 7.542 7.362-7.542-4.377-4.483Z"
                      fill="#2AC9BC"></path>
            </svg>
        </a>
        <h1>Your Morning Update</h1>
    </div>
    @foreach($meetings as $meeting)
        <div class="meeting">
            <div class="time">{{"$meeting->start - $meeting->end"}} | <u>{{ $meeting->title }}</u> ({{$meeting->duration}})</div>
            <div class="meeting-info">
                <p>Joining from UserGems: {{$meeting->host}}</p>
                <div>
                    <span><b><u>{{$company->name}}</u></b></span>
                    <a href="{{$company->linkedin_url}}" class="linkedin">
                        <i class="fa fa-linkedin-square" aria-hidden="true"></i>
                    </a>
                    <i class="fa fa-users" aria-hidden="true">&nbsp;{{$company->employees}}</i>
                </div>
            </div>
        </div>
        @foreach($meeting->participants as $participant)
            <div class="participant">
                <img src="{{$participant->info->avatar ?? 'https://ohsobserver.com/wp-content/uploads/2022/12/Guest-user.png'}}"
                     alt="{{$participant->full_name}}">
                <div>
                    <div class="name">{{$participant->full_name}}
                        @if($participant->confirmed)
                            <i class="fa fa-check-circle" aria-hidden="true" style="color:green;"></i>
                        @else
                            <i class="fa fa-times-circle" aria-hidden="true" style="color:red;"></i>
                        @endif
                        @if($participant->info->linkedin_url)
                            <a href="{{$participant->info->linkedin_url}}" class="linkedin">
                                <i class="fa fa-linkedin-square" aria-hidden="true"></i>
                            </a>
                        @endif
                    </div>
                    <div class="position">{{$participant->info->title}}</div>
                    <div>
                        <span>
                            {{$participant->totalMeetings}}th Meeting
                        </span>
                        @if($participant->meetingWith)
                            <span>
                                | Met with
                                @foreach($participant->meetingWith as $email => $total)
                                    {{$email}} ({{$total}}x)
                                    @if (!$loop->last)
                                        &
                                    @endif
                                @endforeach
                            </span>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
    @endforeach
</div>
</body>
</html>
