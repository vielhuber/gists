SELECT * FROM addresses WHERE
(6371 * ACOS(SIN(RADIANS(48.576809)) * SIN(RADIANS(addresses.lat)) + COS(RADIANS(48.576809)) * COS(RADIANS(addresses.lat)) * COS(RADIANS(addresses.lng) - RADIANS(13.403111)))) < 50