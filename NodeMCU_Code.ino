#include <ESP8266WiFi.h>
#include <ESP8266HTTPClient.h>
#include <WiFiClient.h>

// Replace with your network credentials
//const char* ssid = "H368N0E666A"; // Home network
//const char* password = "57EE73AE33C9";
const char* ssid = "iPhone van Onno"; // School network
const char* password = "NodeMCU567";

int ID = 1;
int Done = 0;

String serverName = "http://snacktastic.000webhostapp.com/arduinoConnect.php";

unsigned long previousMillis = 0;
unsigned long interval = 20000;

void initWiFi() {
  WiFi.mode(WIFI_STA);
  WiFi.begin(ssid, password);
  //Serial.println("Connecting to WiFi ..");
  while (WiFi.status() != WL_CONNECTED) {
    Serial.println('.');
    delay(1000);
  }
  //Serial.println(WiFi.localIP());
  //The ESP8266 tries to reconnect automatically when the connection is lost
  WiFi.setAutoReconnect(true);
  WiFi.persistent(true);
}

void setup() {
  Serial.begin(9600);
  initWiFi();
  //Serial.println("RSSI: ");
  //Serial.println(WiFi.RSSI());
  pinMode(1, OUTPUT);
  pinMode(3, INPUT);
}

void loop() {
  //print the Wi-Fi status every 60 seconds
  unsigned long currentMillis = millis();
  if (currentMillis - previousMillis >=interval){
    switch (WiFi.status()){
      case WL_NO_SSID_AVAIL:
      {
        //Serial.println("Configured SSID cannot be reached");
        break;
      }
      case WL_CONNECTED:
      {
        //Serial.println("Connection successfully established");
        
        WiFiClient client;
        HTTPClient http;

        if(Serial.available())
        {
          Done = Serial.read();
        }
  
        String serverPath = serverName + "?Snack_ID=" + ID + "&Done=" + Done; //Replace with values you need to send
        
        // Your Domain name with URL path or IP address with path
        http.begin(client, serverPath.c_str());
        
        // Send HTTP GET request
        int httpResponseCode = http.GET(); // values you get back from the website
        
        if (httpResponseCode>0) {
          //Serial.println("HTTP Response code: ");
          //Serial.println(httpResponseCode);
          String payload = http.getString();
          if(payload.length() == 0) // give the info to the arduino
          {
            Serial.println('0');
          } else
          {
            Serial.println(payload + " " + payload.length());
          }
          
          //Serial.println(payload);
        }
        else {
          //Serial.print("Error code: ");
          Serial.println(httpResponseCode);
        }
        http.end();
        
        break;
      }
      case WL_CONNECT_FAILED:
      {
        //Serial.println("Connection failed");
        break;
      }
    }
    Serial.println("Connection status:");
    Serial.println(WiFi.status());
    //Serial.println("RRSI: ");
    //Serial.println(WiFi.RSSI());
    previousMillis = currentMillis;
  }
}
