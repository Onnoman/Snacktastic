#include <Servo.h>
#include <..\pitches.h>
#include <..\melodies\melodies.ino>

//Strings used for testing
String ServoOn = "1;#FF00FF;2";
String ServoOff = "0;#8B0000;2";

//used for storing the recieved data from NodeMCU
const int numChars = 32;
char receivedChars[numChars];   // an array to store the received data
char HEXAcolour[6];
int turnState;
int buzzerSong;
boolean newData = false;

//rgb values
int r = NULL;
int g = NULL;
int b = NULL;

//storing IRsensor input
int irvalue = 0;
int hallvalue = 0;

//defines are used for variables that will be unchanged
// this is because defines take up less memory
//servo variables
#define SERVOSPEED 85
#define ROTTIME 1000
#define SERVOSTOP 90

//pins
#define RXPIN 0
#define TXPIN 1
#define HALLPIN 4
#define SERVOPIN 6
#define BUZZERPIN 7
#define IRPIN 8
#define BLUEPIN 9
#define GREENPIN 10
#define REDPIN 11

//servo
Servo servo1;

//states
#define TURN 1
#define IDLESTATE 0
#define NOOBJECT 2

void setup() {
  //pins
  pinMode(TXPIN, OUTPUT);
  pinMode(RXPIN, INPUT);
  pinMode(IRPIN, INPUT);
  pinMode(HALLPIN, INPUT);
  pinMode(REDPIN, OUTPUT);
  pinMode(BLUEPIN, OUTPUT);
  pinMode(GREENPIN, OUTPUT);
  pinMode(BUZZERPIN, OUTPUT);
  servo1.attach(SERVOPIN);
  Serial.begin(9600);
}

void loop() {
  //Serial.print(ServoOn);
  int state = 0;
  
  //at beginning of loop read all inputs
  //Serial.println("Reading NodeMCU input...");
  recvWithEndMarker();  //read input from NodeMCU
  //Serial.println("Reading IR...");
  IRdetection();  //read input from IRsensor

  //finding correct state
  //if new data has been recieved, set state to 1 and convert hexcode to RGB (turnState is variable to which switch part of NODEMCU message is bound) 
  if(newData == true){
    //if nodemcu communicates the arduino to turn servo, set state to TURN
    //Serial.println("New data received, continue");
    if(turnState == 1){
      //Serial.println("State set to TURN");
      state = TURN;
      hexaToRGB(HEXAcolour);
      turnState = 0;
      BuzzerSound(buzzerSong);
    }
    newData = false;
  }
  else if(irvalue == 1){
    //Serial.println("State set to NOOBJECT");
    state = NOOBJECT; 
  }

  else{
    //Serial.println("State set to IDLESTATE");
    state = IDLESTATE;
  }
  
  switch(state){
    // when servo is turned, RGB and Buzzer also need to be activated
    case TURN:
      rotateServo();
      RGBColor(r, g, b);
      BuzzerSound(buzzerSong);
      break;
    // Idlestate is the regular state, standyby mode
    case IDLESTATE:
      //do nothing
      break;
    // 
    case NOOBJECT:
      Serial.println(1);
      break;
  }
  delay(10000);
}

//function used to recieve the strings that has been send from NodeMCU
void recvWithEndMarker() {
    static int ndx = 0;
    char endMarker = '\n';
    char rc;
    //Serial.println(newData);
    while (Serial.available() > 0 && newData == false) {
        //Serial.println(Serial.available());
        rc = Serial.read();
        //Serial.println(rc);
        if (rc != endMarker) {
            receivedChars[ndx] = rc;
            ndx++;
            if (ndx >= numChars) {
                ndx = numChars - 1;
            }
        }
        else {    
            receivedChars[ndx] = '\0'; // terminate the string
            //Serial.println(receivedChars);
            ndx = 0;
            newData = true;

            //seperate received string
            turnState = receivedChars[0] - 48; //Subtract 48 manually because for unknown reason 48 gets added when assigning value to variable
            //Serial.println(turnState);
            for(int i = 2; i<=8; i++){
               HEXAcolour[i-2] = receivedChars[i];
            }
            //Serial.println(sizeof(HEXAcolour));
            //Serial.println(HEXAcolour);
            buzzerSong = receivedChars[10] - 48;
            //Serial.println(buzzerSong);
            Serial.println(receivedChars);
        }
    }
}

void Hallmodule(){     //function that will read irsensor and return its value
  hallvalue = digitalRead(HALLPIN);
  //Serial.println(hallvalue);        //debug
}

void IRdetection(){     //function that will read irsensor and return its value
  irvalue = digitalRead(IRPIN);
  //Serial.println(irvalue);        //debug
}

void rotateServo(){
  servo1.write(SERVOSPEED); //Start rotating at fairly slow pace
  delay(ROTTIME); //Keep rotating for ~0.65 seconds: 72 degrees
  Hallmodule();
  if(hallvalue ==1){
    servo1.write(SERVOSTOP); //Stop rotating  
  }
}

void RGBColor(int red_light_value, int green_light_value, int blue_light_value)
 {
  analogWrite(REDPIN, red_light_value);
  analogWrite(GREENPIN, green_light_value);
  analogWrite(BLUEPIN, blue_light_value);
}

void hexaToRGB(String hexa_string)
{
  hexa_string.remove(0,1); //Remove # from string for easier processing
  
  char charbuf[8];
  hexa_string.toCharArray(charbuf,8);
  long int rgb=strtol(charbuf,0,16); //=>rgb=0x001234FE;
  r=(int)(rgb>>16); //Convert red value, etc..
  g=(int)(rgb>>8);
  b=(int)(rgb);
}

//put songs here
//SONG FUNCTIONS CAN BE FOUND IN THE FILE: MELODIES.INO
void BuzzerSound(int song){
  if(song == 1){
    superMario();
  }
  else if(song == 2){
    furElise();
  }
}
