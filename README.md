# Assesment Test


## Untuk mencoba endpoint order bisa pakai Curl dibawah
curl --location 'http://127.0.0.1:8000/order' \
--header 'Content-Type: application/json' \
--header 'Accept: application/json' \
--header 'Cookie: XSRF-TOKEN=eyJpdiI6ImhiK3Z0c3ZJS3RJL29FZVVaSmozcEE9PSIsInZhbHVlIjoidWlQUHdpTEwyMUpBOExLaitnMlYwQXhNZG9BSUExdEZ0aTNUUlk1M2toeWRtb1hwcnRYQzhGRU5NYVk3L1B5NnYzcG5yTHNuZVpDWjVKbitCcnpqdkxmb3RsVElTbDJTNGV3dmRQUXRSRTFsQUdFQjJ5Z2tOM3hVT1VHZ3JvSloiLCJtYWMiOiI0OWU4NDRjMmNjOTBmZjA2YWEyZGU4NWIwYTg5YzFlMjg5M2Q2Y2UwZDQzMTg0NTU0NzliZjVjMGI5ZTUxODVhIiwidGFnIjoiIn0%3D; laravel_session=eyJpdiI6IlVRWEJaeldSUUlFanJLWnEwa25aWEE9PSIsInZhbHVlIjoiZGdnSWduU004c1ViNW1FM3pyRUJFRjA2TGFyNUtGRDNMSFhOS0ZOQUVWRGNRcWEwcnJ0NUtaN2pVVnBLSTd4bTExZG53RnowOXVwOXcvQzRLQy9MY25OM3ZwVE1sdzZmbXp0bG9Jc21zTzlSZkRXUTF6cms4Mm10TlVFWGJrb0giLCJtYWMiOiJjMjQzMzgzOGYyN2Q4MmI5ZmQxNjJjYjZjZjdjMjk4YTQ1MjBhODBlYTczMTJjMmYwMjc2NGIyZjQyOGU0YmY3IiwidGFnIjoiIn0%3D' \
--data '{
    "product_id": 1,
    "quantity": 5
}'

## Jangan lupa untuk set data dummy productnya

## Untuk run test nya bisa pakai ini
php artisan test tests/Feature/OrderServiceTest.php