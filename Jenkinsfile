pipeline {
    agent any
    stages {
        stage("Check versions") {
            steps {
                sh '''
                    docker version
                    docker-compose version
                '''
            }
        }
        stage("Prune docker data") {
            steps {
                sh '''
                    docker system prune -a --volumes -f
                '''
            }
        }
        stage("Start containers") {
            steps {
                sh 'docker-compose up -d --build'
                sh 'docker ps'
            }
        }
    }
    post {
        failure {
            sh 'docker-compose down'
            sh 'docker ps'
        }
    }
}
