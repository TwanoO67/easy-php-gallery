echo -e "\033[32m"
echo -e "===================================================================================================="
echo -e " "
echo -e " _____                 ______ _   _ ______ _           _          _____       _ _                   "       
echo -e "|  ___|                | ___ \ | | || ___ \ |         | |        |  __ \     | | |                  "      
echo -e "| |__  __ _ ___ _   _  | |_/ / |_| || |_/ / |__   ___ | |_ ___   | |  \/ __ _| | | ___ _ __ _   _   "
echo -e "|  __|/ _  / __| | | | |  __/|  _  ||  __/| |_ \ / _ \| __/ _ \  | | __ / _  | | |/ _ \ |__| | | |  "
echo -e "| |__| (_| \__ \ |_| | | |   | | | || |   | | | | (_) | || (_) | | |_\ \ (_| | | |  __/ |  | |_| |  "
echo -e "\____/\__,_|___/\__, | \_|   \_| |_/\_|   |_| |_|\___/ \__\___/   \____/\__,_|_|_|\___|_|   \__, |  "
echo -e "                 __/ |                                                                       __/ |  "
echo -e "                |___/                                                                       |___/   "
echo -e " "
echo -e "===================================================================================================="
echo -e " "
echo -e "      🐳 EASY PHPhoto GALLERY - INSTALL  "
echo -e " "
echo -e "=================================================================="
echo -e " "
echo -e "\033[0m"

if [ -z "$PORT" ]
then
    read -p " Sur quel port voulez vous faire tourner le serveur ? (default: 100) " PORT
fi
if [ -z "${PORT}" ]
then
    PORT=100
fi

if [ -z "$DOMAIN_NAME" ]
then
    read -p " Quel est votre url d'accès externe ? (example: http://my_nas_serveur.com:85 ) " DOMAIN_NAME
fi
if [ -z "${DOMAIN_NAME}" ]
then
    DOMAIN_NAME="http://localhost:$PORT"
fi

if [ -z "$PHOTO_DIR" ]
then
    read -p " Quel est votre dossier de photos ? (example: /Users/TwanoO/Photos ) " PHOTO_DIR
fi
if [ -z "$PHOTO_DIR" ]
then
    echo -e " Nous avons besoin de vos photos pour continuer... désolé.";
    exit;
fi


if [ ! -f .env ]; then
    echo "Création du fichier d'env docker"
    cp .env.example .env
    sed -i -e "s#APP_PORT=100#http://APP_PORT=${PORT}#g" .env
    sed -i -e "s#PHOTO_DIR=/Users/TwanoO/Downloads#PHOTO_DIR=${PHOTO_DIR}#g" .env
fi

if [ ! -f src/.env ]; then
    echo "Création du fichier d'env de laravel"
    cp src/.env.example src/.env

    echo "Copie de votre adresse externe"
    sed -i -e "s#APP_URL=http://localhost:100#${DOMAIN_NAME}#g" .env
fi

docker-compose build
docker-compose up -d

echo "Attente du container PHP..."
until [ "`/usr/bin/docker inspect -f {{.State.Running}} EPG_php`"=="true" ];
do
    sleep 2
done
echo "OK"

echo -e "\033[32m"
echo -e "=================================================================="
echo -e " Lancement de l'installation "
echo -e "\033[0m"

sleep 10

docker exec -e COLUMNS="$DCK_COLUMNS" -e LINES="$DCK_LINES" -it "EPG_php" bash -c "/var/www/html/init.sh"