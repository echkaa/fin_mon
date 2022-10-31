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
        stage("Down previous") {
            steps {
                sh '''
                    docker-compose down
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
