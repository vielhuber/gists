Private Sub Application_ItemSend(ByVal Item As Object, Cancel As Boolean)
    Dim Mail As Outlook.MailItem
    If TypeOf Item Is Outlook.MailItem Then
        Set Mail = Item
        If Now < TimeValue("18:00:00") Then
            Mail.DeferredDeliveryTime = Date & " 18:00:00"
        Else
            Mail.DeferredDeliveryTime = DateValue(DateAdd("h", 24, Now)) & " 18:00:00"
        End If
    End If
End Sub