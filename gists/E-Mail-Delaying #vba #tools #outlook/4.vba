Private Sub Application_ItemSend(ByVal Item As Object, Cancel As Boolean)
    Dim Mail As Outlook.MailItem
    If TypeOf Item Is Outlook.MailItem Then
        Set Mail = Item
        Dim d As Date
        d = DateAdd("d", 1, Date)
        Select Case Weekday(d, vbMonday)
            Case 6: d = DateAdd("d", 2, d)
            Case 7: d = DateAdd("d", 1, d)
        End Select
        d = d & " 09:00:00"
        Response = MsgBox("Wollen Sie diese E-Mail verzögern auf den Zeitpunkt " & d & "?", vbYesNoCancel + vbQuestion + vbMsgBoxSetForeground, "E-Mail-Verzögerung")
        If Response = vbYes Then
            Mail.DeferredDeliveryTime = d
        Elseif Response = vbCancel Then
            Cancel = True
        End If
    End If
End Sub