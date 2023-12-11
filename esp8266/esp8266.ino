#include <ESP8266WiFi.h>
#include <Wire.h>
#include <LiquidCrystal_I2C.h>
#include <WiFiClient.h>
#include <ESP8266WebServer.h>
#include <ESP8266HTTPClient.h>

//Các biến thông tin để kết nối và gửi dữ liệu
const char* ssid = "Nha 17E 2.4G";
const char* password = "0389349639";
const char* serverAddress = "http://192.168.1.10/demo/postdemo.php"; 

WiFiClient client;

// Khai báo biến cho màn hình LCD I2C
const int lcdColumns = 16;  // Số cột màn hình LCD I2C
const int lcdRows = 2;      // Số dòng màn hình LCD I2C
LiquidCrystal_I2C lcd(0x27, lcdColumns, lcdRows);

void setup() {
  delay(1000);
  Serial.begin(115200);
  //kết nối đến wifi
  WiFi.mode(WIFI_STA);
  WiFi.begin(ssid, password);

  Serial.println("Connecting to WiFi...");
  while (WiFi.status() != WL_CONNECTED) {
    delay(500);
    Serial.print(".");
  }

  Serial.println("Connected to WiFi");

  // Khởi tạo màn hình LCD I2C
  lcd.init();
  lcd.backlight();
  lcd.clear();
}

void loop() {
  HTTPClient http;

  //tính toán nhiệt độ đo được từ lm35
  int lm35Pin = A0;
  float voltage, temperature;
  int sensorValue = analogRead(lm35Pin);
  voltage = (sensorValue / 1024.0) * 5000; 
  temperature = (voltage + 300) / 10.0;

  String postData = "temperature=" + String(temperature);

  //sử dụng http post để gửi nhiệt độ đo được lên máy chủ
  http.begin(client, serverAddress);
  http.addHeader("Content-Type", "application/x-www-form-urlencoded");

  int httpCode = http.POST(postData);
  String response = http.getString();

  //hiển thị các thông tin phản hồi lên màn hình debug
  Serial.println("HTTP Code: " + String(httpCode));
  Serial.println("Server Response: " + response);

  http.end();

  // Hiển thị nhiệt độ lên màn hình LCD I2C
  lcd.clear();
  lcd.setCursor(0, 0);
  lcd.print("Temperature:");
  lcd.setCursor(0, 1);
  lcd.print(temperature, 2);  // Hiển thị nhiệt độ với 2 chữ số thập phân

  delay(5000);  // Gửi dữ liệu mỗi 5 giây
}
