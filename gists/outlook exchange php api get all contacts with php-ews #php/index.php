<?php
require_once __DIR__ . '/vendor/autoload.php';
use jamesiarmes\PhpEws\Client;
use jamesiarmes\PhpEws\Request\FindItemType;
use jamesiarmes\PhpEws\ArrayType\NonEmptyArrayOfBaseFolderIdsType;
use jamesiarmes\PhpEws\Enumeration\DistinguishedFolderIdNameType;
use jamesiarmes\PhpEws\Enumeration\ResponseClassType;
use jamesiarmes\PhpEws\Type\ContactsViewType;
use jamesiarmes\PhpEws\Type\DistinguishedFolderIdType;
use jamesiarmes\PhpEws\Type\ItemResponseShapeType;
use jamesiarmes\PhpEws\Enumeration\DefaultShapeNamesType;
use jamesiarmes\PhpEws\Enumeration\ItemQueryTraversalType;
use jamesiarmes\PhpEws\Enumeration\IndexBasePointType;
use jamesiarmes\PhpEws\Type\IndexedPageViewType;
use jamesiarmes\PhpEws\Request\UpdateItemType;
use jamesiarmes\PhpEws\ArrayType\NonEmptyArrayOfItemChangeDescriptionsType;
use jamesiarmes\PhpEws\Enumeration\ConflictResolutionType;
use jamesiarmes\PhpEws\Type\ItemChangeType;
use jamesiarmes\PhpEws\Type\ItemIdType;
use jamesiarmes\PhpEws\Type\SetItemFieldType;
use jamesiarmes\PhpEws\Type\ContactItemType;
use jamesiarmes\PhpEws\Type\PathToIndexedFieldType;
use jamesiarmes\PhpEws\Type\PathToUnindexedFieldType;
use jamesiarmes\PhpEws\Enumeration\UnindexedFieldURIType;
use jamesiarmes\PhpEws\Request\CreateItemType;
use jamesiarmes\PhpEws\Enumeration\BodyTypeType;
use jamesiarmes\PhpEws\Enumeration\EmailAddressKeyType;
use jamesiarmes\PhpEws\Enumeration\FileAsMappingType;
use jamesiarmes\PhpEws\Enumeration\MapiPropertyTypeType;
use jamesiarmes\PhpEws\Enumeration\PhoneNumberKeyType;
use jamesiarmes\PhpEws\Enumeration\PhysicalAddressKeyType;
use jamesiarmes\PhpEws\Type\BodyType;
use jamesiarmes\PhpEws\Type\EmailAddressDictionaryEntryType;
use jamesiarmes\PhpEws\Type\EmailAddressDictionaryType;
use jamesiarmes\PhpEws\Type\ExtendedPropertyType;
use jamesiarmes\PhpEws\Type\PathToExtendedFieldType;
use jamesiarmes\PhpEws\Type\PhoneNumberDictionaryEntryType;
use jamesiarmes\PhpEws\Type\PhysicalAddressDictionaryEntryType;
use jamesiarmes\PhpEws\Type\PhoneNumberDictionaryType;

class ExchangeContacts
{
    private $client = null;

    public function __construct()
    {
        $this->client = new Client('***host****', '***email****', '***password****', Client::VERSION_2013);
    }

    public function getAllContacts()
    {
        $limit = 1000;
        $request = new FindItemType();
        $request->ItemShape = new ItemResponseShapeType();
        $request->ItemShape->BaseShape = DefaultShapeNamesType::ALL_PROPERTIES;
        $request->ParentFolderIds = new NonEmptyArrayOfBaseFolderIdsType();
        $request->ContactsView = new ContactsViewType();
        $request->IndexedPageItemView = new IndexedPageViewType();
        $request->IndexedPageItemView->BasePoint = IndexBasePointType::BEGINNING;
        $request->IndexedPageItemView->Offset = 0;
        $request->IndexedPageItemView->MaxEntriesReturned = $limit;
        $folder_id = new DistinguishedFolderIdType();
        $folder_id->Id = DistinguishedFolderIdNameType::CONTACTS;
        $request->ParentFolderIds->DistinguishedFolderId[] = $folder_id;
        $request->Traversal = ItemQueryTraversalType::SHALLOW;
        $response = $this->client->FindItem($request);

        $contacts = [];
        foreach ($response->ResponseMessages->FindItemResponseMessage as $response_message) {
            if ($response_message->ResponseClass != ResponseClassType::SUCCESS) {
                continue;
            }
            $contacts = array_merge($contacts, $response_message->RootFolder->Items->Contact);
            $last_page = $response_message->RootFolder->IncludesLastItemInRange;
            $page_number = 1;
            while (!$last_page) {
                $request->IndexedPageItemView->Offset = $limit * $page_number;
                $response = $this->client->FindItem($request);
                foreach ($response->ResponseMessages->FindItemResponseMessage as $response_message_this) {
                    $contacts = array_merge($contacts, $response_message_this->RootFolder->Items->Contact);
                }
                $last_page = $response_message_this->RootFolder->IncludesLastItemInRange;
                $page_number++;
            }
        }

        return $contacts;
    }

    public function fixDisplayNames()
    {
        $request = new UpdateItemType();
        $request->ConflictResolution = ConflictResolutionType::ALWAYS_OVERWRITE;

        $contacts = $this->getAllContacts();
        foreach ($contacts as $contacts__value) {
            if ($contacts__value->Surname !== 'Alcala') {
                continue;
            }

            //$contacts__value->FileAs = $contacts__value->CompleteName->FullName;
            //$contacts__value->Subject = $contacts__value->CompleteName->FullName;

            $change = new ItemChangeType();
            $change->ItemId = new ItemIdType();
            $change->ItemId->Id = $contacts__value->ItemId->Id;
            $change->Updates = new NonEmptyArrayOfItemChangeDescriptionsType();

            $field = new SetItemFieldType();
            $field->IndexedFieldURI = new PathToUnindexedFieldType();
            $field->IndexedFieldURI->FieldURI = UnindexedFieldURIType::CONTACTS_FILE_AS;
            $field->Contact = new ContactItemType();
            $field->Contact->fileAs = $contacts__value->CompleteName->FullName;
            $change->Updates->SetItemField[] = $field;

            $request->ItemChanges[] = $change;
            //var_dump([$contacts__value->ItemId->Id, $contacts__value->DisplayName, $contacts__value]);
            //die('OK');
        }
        $response = $this->client->UpdateItem($request);
        return true;
    }

    public function addContact($data)
    {
        $request = new CreateItemType();
        $contact = new ContactItemType();
        $contact->GivenName = $data['first_name'];
        $contact->Surname = $data['last_name'];
        $contact->EmailAddresses = new EmailAddressDictionaryType();
        $contact->PhoneNumbers = new PhoneNumberDictionaryType();

        foreach ($data['emails'] as $emails__key => $emails__value) {
            $email = new EmailAddressDictionaryEntryType();
            if ($emails__key === 0) {
                $email->Key = EmailAddressKeyType::EMAIL_ADDRESS_1;
            } elseif ($emails__key === 1) {
                $email->Key = EmailAddressKeyType::EMAIL_ADDRESS_2;
            } elseif ($emails__key === 2) {
                $email->Key = EmailAddressKeyType::EMAIL_ADDRESS_3;
            } else {
                continue;
            }
            $email->_ = $emails__value;
            $contact->EmailAddresses->Entry[] = $email;
        }

        foreach ($data['phones'] as $phones__key => $phones__value) {
            foreach ($phones__value as $phones__value__key => $phones__value__value) {
                $phone = new PhoneNumberDictionaryEntryType();

                if ($phones__key === 'private') {
                    if ($phones__value__key === 0) {
                        $phone->Key = PhoneNumberKeyType::HOME_PHONE;
                    } elseif ($phones__value__key === 1) {
                        $phone->Key = PhoneNumberKeyType::HOME_PHONE_2;
                    } else {
                        continue;
                    }
                } elseif ($phones__key === 'business') {
                    if ($phones__value__key === 0) {
                        $phone->Key = PhoneNumberKeyType::BUSINESS_PHONE;
                    } elseif ($phones__value__key === 1) {
                        $phone->Key = PhoneNumberKeyType::BUSINESS_PHONE_2;
                    } else {
                        continue;
                    }
                } else {
                    continue;
                }

                $phone->_ = $phones__value__value;
                $contact->PhoneNumbers->Entry[] = $phone;
            }
        }

        $contact->FileAsMapping = FileAsMappingType::FIRST_SPACE_LAST;

        $request->Items->Contact[] = $contact;
        $response = $this->client->CreateItem($request);
    }
}

$exchangecontacts = new ExchangeContacts();
//$exchangecontacts->fixDisplayNames();

$exchangecontacts->addContact([
    'first_name' => 'David',
    'last_name' => 'Vielhuber',
    'emails' => ['david@vielhuber.de'],
    'phones' => ['private' => ['+4915158754691'], 'business' => ['+4989546564']]
]);
die();

$contacts = $exchangecontacts->getAllContacts();
foreach ($contacts as $contacts__value) {
    var_dump([
        $contacts__value->ItemId->Id,
        $contacts__value->DisplayName,
        $contacts__value->CompanyName,
        $contacts__value->EmailAddresses,
        $contacts__value->PhoneNumbers
    ]);
}
