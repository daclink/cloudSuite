#mrbook.org/tutorials/make
SOURCES=*.cpp
EXECUTABLE=test.exe
#=-=-=-=-=-=-=-=
CC=g++
#=-=-=-=-=-=-=-=
CFLAGS=-c -Wall
LDFLAGS=
OBJECTS=$(SOURCES:.cpp=.o)
#=-=-=-=-=-=-=
all: $(SOURCES) $(EXECUTABLE)
	
$(EXECUTABLE): $(OBJECTS) 
	$(CC) $(LDFLAGS) $(OBJECTS) -o $@

.cpp.o:
	$(CC) $(CFLAGS) $< -o $@

clean:
	rm -rf *.o

clean-all:
	rm -rf *.o $(EXECUTABLE)
