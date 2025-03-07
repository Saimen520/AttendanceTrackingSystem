#include <SPI.h>
#include <MFRC522.h>
#include <WiFi.h>
#include <HTTPClient.h>


const char* ssid = "B100M";
const char* password = "12345678";

const char* serverUrl = "http://192.168.200.101:8000/api/attendance";


#define RST_PIN 22
#define SS_PIN 21


#define BUZZER_PIN 5  

MFRC522 mfrc522(SS_PIN, RST_PIN);  

void setup() {
  Serial.begin(115200);
  SPI.begin(); 
  mfrc522.PCD_Init();

  pinMode(BUZZER_PIN, OUTPUT);  

  WiFi.begin(ssid, password);
  Serial.print("Connecting to WiFi");

  unsigned long startAttemptTime = millis(); 
  while (WiFi.status() != WL_CONNECTED && millis() - startAttemptTime < 10000) {
    delay(500);
    Serial.print(".");
  }

  if (WiFi.status() == WL_CONNECTED) {
    Serial.println("\n✅ Connected to WiFi!");
  } else {
    Serial.println("\n❌ WiFi connection failed!");
  }
}

void loop() {
  if (WiFi.status() != WL_CONNECTED) {
    Serial.println("🔴 WiFi disconnected. Attempting reconnect...");
    WiFi.begin(ssid, password);
    delay(5000);  
  }

  if (mfrc522.PICC_IsNewCardPresent() && mfrc522.PICC_ReadCardSerial()) {
    String uid = byteArrayToHexString(mfrc522.uid.uidByte, mfrc522.uid.size);
    Serial.println("🔹 Scanned UID: " + uid);

    beepBuzzer(1, 100);  

    sendUidToServer(uid);

   
    mfrc522.PICC_HaltA();
  }
}


String byteArrayToHexString(byte* array, byte length) {
  String hexString = "";
  for (byte i = 0; i < length; i++) {
    if (array[i] < 0x10) {
      hexString += "0";  
    }
    hexString += String(array[i], HEX);
  }
  hexString.toUpperCase(); 
  return hexString;
}


void sendUidToServer(String uid) {
  if (WiFi.status() != WL_CONNECTED) {
    Serial.println("🔴 WiFi disconnected. Skipping request...");
    return;
  }

  HTTPClient http;
  http.begin(serverUrl);
  http.addHeader("Content-Type", "application/json");

  String jsonPayload = "{\"rfid_uid\":\"" + uid + "\"}";
  //Serial.println("📤 Sending to Server: " + jsonPayload);

  int httpResponseCode = http.POST(jsonPayload);

  if (httpResponseCode > 0) {
    String response = http.getString();
    Serial.println("✅ Server Response: " + response);

   
    if (response.indexOf("User not found") != -1) {
      Serial.println("❌ Invalid Card!");
      beepBuzzer(1, 1000);  
    }
  } else {
    Serial.println("❌ HTTP Request Failed! Error: " + String(httpResponseCode));
    beepBuzzer(1, 1000);  
  }

  http.end();  // Free resources
}

// Function to beep buzzer
void beepBuzzer(int times, int duration) {
  for (int i = 0; i < times; i++) {
    digitalWrite(BUZZER_PIN, HIGH);
    delay(duration);
    digitalWrite(BUZZER_PIN, LOW);
    delay(100);  
  }
}
