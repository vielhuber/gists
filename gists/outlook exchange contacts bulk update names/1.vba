'https://www.slipstick.com/outlook/contacts/bulk-change-outlook-contacts-email-display-name-format/

'ALT+F11 > ThisOutlookSession > Select > Run

Public Sub ChangeFileAs()
    Dim objOL As Outlook.Application
    Dim objNS As Outlook.NameSpace
    Dim objContact As Outlook.ContactItem
    Dim objItems As Outlook.Items
    Dim objContactsFolder As Outlook.MAPIFolder
    Dim obj As Object
    Dim strFirstName As String
    Dim strLastName As String
    Dim strFileAs As String
    On Error Resume Next
    Set objOL = CreateObject("Outlook.Application")
    Set objNS = objOL.GetNamespace("MAPI")
    Set objContactsFolder = objNS.GetDefaultFolder(olFolderContacts)
    Set objItems = objContactsFolder.Items
    For Each obj In objItems
        If obj.Class = olContact Then
            Set objContact = obj
            With objContact                
              
              .FileAs = .FullName
              .Subject = .FullName
              If .Email1Address <> "" Then
                  .Email1DisplayName = .FullName & " (" & .Email1Address & ")"
              End If
              .Save
                
            End With
        End If
        Err.Clear
    Next
    Set objOL = Nothing
    Set objNS = Nothing
    Set obj = Nothing
    Set objContact = Nothing
    Set objItems = Nothing
    Set objContactsFolder = Nothing
End Sub