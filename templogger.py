#!/usr/bin/env python
#-------------------------------------------------------#
#templogger.py                                          #
#Nile Fairfield 2/25/2015                               #
#                                                       #
#Script to run query temperature and write to SQL       #
#-------------------------------------------------------#

#Import
import sys
import subprocess
import os
import time
import datetime
import MySQLdb as mdb

#Initialization
mysqlUser = "monitor"
mysqlPass = "password"
mysqlDatabase = "hometemp"
mysqlHost = "localhost"
mysqlPort = 3306
id = '28-000006775f09' #Sensor ID. This will need to change for various sensors
count = 0

#-------------------------------------------------------#
#writeTemp                                              #
#inputs: temperature to write to database               #
#-------------------------------------------------------#
def writeTemp(temperature):
#        current_time = time.strftime("%H:%M:%S")
#        current_date = time.strftime("%Y/%m/%d")

        #Connect to database
        conDB = mdb.connect(mysqlHost, mysqlUser, mysqlPass, mysqlDatabase, mysqlPort)
        cursor = conDB.cursor()

        #Write to database
        try:
               cursor.execute("INSERT INTO tempdata(sensor,temperature) VALUES (%s,%s)",(id,temperature))
               conDB.commit()
        except:
                print "Error writing to the database"
        finally:
                cursor.close()
                conDB.close()


#-------------------------------------------------------#
#function gettemp                                       #
#inputs: string id for temperature sensor               #
#outputs: returns the temp in C as an integer place     #
#       shifted. Divide by 1000 to get Degrees C        #
#-------------------------------------------------------#
def gettemp(id):
  try:
    mytemp = ''
    filename = 'w1_slave'
    f = open('/sys/bus/w1/devices/' + id + '/' + filename, 'r')
    line = f.readline() # read 1st line
	crc = line.rsplit(' ',1)
	crc = crc[1].replace('\n', '')
    if crc=='YES':
      line = f.readline() # read 2nd line
      mytemp = line.rsplit('t=',1)
    else:
      mytemp = 99999
    f.close()

    return int(mytemp[1])

  except:
    return 99999

#Main execution
while (count < 5):
        tempc = gettemp(id)/float(1000)
        tempf = 9.0/5.0 * tempc + 32
#       print "Temp : ",tempc,"C or ",tempf,"F"
        writeTemp(tempf)
        count = count + 1
        time.sleep(5)

