Private Sub Application_ItemSend(ByVal Item As Object, Cancel As Boolean)
    Dim Mail As Outlook.MailItem
    If TypeOf Item Is Outlook.MailItem Then
        Set Mail = Item
        Mail.DeferredDeliveryTime = DateAdd("h", 8, Now)
    End If
End Sub