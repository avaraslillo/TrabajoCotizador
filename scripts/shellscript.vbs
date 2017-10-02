Set WinScriptHost = CreateObject("WScript.Shell")
WinScriptHost.Run Chr(34) & "C:\wamp\www\CotizadorOnline\scripts\script.bat" & Chr(34), 0
Set WinScriptHost = Nothing