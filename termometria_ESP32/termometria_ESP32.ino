#include <Wire.h>
#include <Adafruit_Sensor.h>
#include <Adafruit_BME280.h>
#include <WiFi.h>
#include <NTPClient.h>
#include <WiFiUdp.h>
#include <HTTPClient.h>
#include <EEPROM.h>

#define EEPROM_SIZE 512
#define MESSAGE_SIZE 64
#define MAX_MESSAGES ((EEPROM_SIZE-1)/MESSAGE_SIZE)

//Config

const char* ssid = "malina";
const char* password = "michalfila";
const char* API_URL = "http://malina.local/api";

const unsigned long API_INTERVAL_MS = 1000;
const unsigned long BASE_INTERVAL_MS = 1000 * 60 * 60;

const String Device_ID = "snowball_1";

//Globalne

WiFiUDP ntpUDP;
NTPClient timeClient(ntpUDP, "pool.ntp.org", 0);

HTTPClient http;

Adafruit_BME280 bme;

unsigned long apiDelayTime;
long baseDelayTime;

//Funkcje startowe

void setupWiFi()
{
    WiFi.mode(WIFI_STA);
    WiFi.begin(ssid, password);
    while (WiFi.status() != WL_CONNECTED)
    {
        delay(500);
        Serial.print("WIFI_err");
    }
    Serial.println();
    Serial.print("IP address: ");
    Serial.println(WiFi.localIP());
}

void setupNtpTime()
{
    timeClient.begin();
    delay(1000);
    while (!timeClient.update())
    {
        Serial.println("NTP_err");
        timeClient.forceUpdate();
    }
}

void setupSensor() 
{
    if (!bme.begin(0x76))
    {
        Serial.println("BME280 nieznaleziony");
        while (true);
    }
}

// funkcje eeprom

void setupEEPROM() 
{
    EEPROM.begin(EEPROM_SIZE);

    byte count = EEPROM.read(0);
    if (count == 0xFF)
    {
        EEPROM.write(0, 0);
        EEPROM.commit();
    }
}


byte getFailedPostCount()
{
    return EEPROM.read(0);
}

void saveFailedPost(String messageS)
{
    byte count = getFailedPostCount();
    if (count >= MAX_MESSAGES)
    {
        Serial.println("EEPROM pełny");
        return;
    }

    char buffer[MESSAGE_SIZE];
    messageS.toCharArray(buffer, MESSAGE_SIZE);

    int start = 1 + count * MESSAGE_SIZE;
    EEPROM.put(start, buffer);
    EEPROM.write(0, count + 1);
    EEPROM.commit();

    Serial.print("Zapisano na EEPROM"); Serial.println(count);
}



void eepromPostDump()
{
    byte count = getFailedPostCount();
    if (count == 0) return;
    for (byte i = 0; i < count; i++)
    {
        char buffer[MESSAGE_SIZE];
        int start = 1 + i * MESSAGE_SIZE;
        EEPROM.get(start, buffer);
        String failedMessageS = String(buffer);

        if (failedMessageS.length() > 0)
        {
            http.begin(API_URL);
            delay(apiDelayTime);
            int httpCode = http.POST(failedMessageS);
            Serial.println(count);
            Serial.println("Eprom Dump");
            Serial.println(httpCode);
            http.end();
        }
        
    }
}

void eepromClear()
{
  for (int i = 0; i < EEPROM_SIZE; i++) EEPROM.write(i, 0);
  EEPROM.commit();
}

//Funkcje pętli programu

String createMessurementS()
{
    
    String formattedDate;
    formattedDate = timeClient.getEpochTime();
    return Device_ID + "\n" +
           bme.readTemperature() + "\n" +
           (bme.readPressure() / 100.0F) + "\n" +
           bme.readHumidity() + "\n" +
           formattedDate;
}

void apiGetCall()
{
  http.begin(API_URL);

  int httpCode = http.GET();
  Serial.println(httpCode);
  
  if (httpCode <= 0) return http.end();

  String response = http.getString();
  Serial.println("GET response:");
  Serial.println(response);

  if (response.indexOf(Device_ID) >= 0) baseDelayTime = 0;

  http.end();
}

void apiPostCall(String messageS)
{
  http.begin(API_URL);

  int responseCode = http.POST(messageS);
  Serial.println(responseCode);

  if(responseCode <=0)
  {
    saveFailedPost(messageS);
  }
  else
  {
    eepromPostDump();
    eepromClear();
  }
  baseDelayTime = BASE_INTERVAL_MS;

  http.end();
}

// Program właściwy

void setup()
{
    Serial.begin(115200);
    Serial.println(F("BME280 test"));

    setupWiFi();
    setupNtpTime();
    setupSensor();
    setupEEPROM();

    apiDelayTime = API_INTERVAL_MS;
    baseDelayTime = BASE_INTERVAL_MS;
}

//Pętla programu właściwego

void loop()
{
    apiGetCall();

    if (baseDelayTime <= 0)
    {
        String messageS = createMessurementS();
        apiPostCall(messageS);
        Serial.println("send");
    }

    delay(apiDelayTime);
    baseDelayTime -= apiDelayTime;
}