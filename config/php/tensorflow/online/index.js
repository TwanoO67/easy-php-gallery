const tf = require('@tensorflow/tfjs')
require('@tensorflow/tfjs-node')
const mobilenet = require('@tensorflow-models/mobilenet');

const fs = require('fs');
const jpeg = require('jpeg-js');

const NUMBER_OF_CHANNELS = 3

const readImage = path => {
  const buf = fs.readFileSync(path)
  const pixels = jpeg.decode(buf, true)
  return pixels
}

const imageByteArray = (image, numChannels) => {
  const pixels = image.data
  const numPixels = image.width * image.height;
  const values = new Int32Array(numPixels * numChannels);

  for (let i = 0; i < numPixels; i++) {
    for (let channel = 0; channel < numChannels; ++channel) {
      values[i * numChannels + channel] = pixels[i * 4 + channel];
    }
  }

  return values
}

const imageToInput = (image, numChannels) => {
  const values = imageByteArray(image, numChannels)
  const outShape = [image.height, image.width, numChannels];
  const input = tf.tensor3d(values, outShape, 'int32');

  return input
}


const classify = async ( path) => {
  const image = readImage(path)
  const input = imageToInput(image, NUMBER_OF_CHANNELS)

  const mn_model = await mobilenet.load(1,1);
  const predictions = await mn_model.classify(input)

  console.log('classification results:', predictions)
}

//if (process.argv.length !== 4) throw new Error('incorrect arguments: node script.js <MODEL> <IMAGE_FILE>')

//const model = "/var/www/tensorflow/old/static/mobilenet/model.json"; //process.argv[2]
const image = '/mydata/malouky.jpeg'; // process.argv[3]
classify(image)
